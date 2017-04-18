<?php
namespace common\behaviors;

use common\models\Uri;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

class UriBehavior extends Behavior
{
    /**
     * Array of relations
     * @var array
     */
    public $parents;

    public $slug = 'slug';
    public $route;

    public $uriRelation = 'uris';

    public function events() {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
        ];
    }

    public function afterSave() {
        /** @var ActiveRecord $model */
        $model = $this->owner;

        $tx = \Yii::$app->db->beginTransaction();

        if (is_callable($this->slug)) {
            $slug = call_user_func($this->slug, $model);
        } else {
            $slug = $model->{$this->slug};
        }
        if (!$slug)
            return;

        $canonicalUriOld = $model->getUris()->andWhere('canonical_id IS NULL AND redirect_id IS NULL')->one();
        $canonicalUrisOld = [];
        $canonicalUris = [];

        if($this->parents) {
            foreach ($model->getRelation($this->uriRelation)->andWhere('redirect_id IS NULL')->all() as $Uri) {
                /** @var Uri $Uri */
                $fullRoute = $Uri->route;
                list(, $params_str) = explode('?', $fullRoute);
                $routeParams = [];
                parse_str($params_str, $routeParams);
                $canonicalUrisOld[$Uri->id] = $Uri;
                $routeParams['slug'] = $slug;
                $Uri2 = $this->makeUrl($Uri->parent, $routeParams, $model);
                if ($Uri2->id != $Uri->id) {
                    $Uri->redirect_id = $Uri2->id;
                    if (!$Uri->save())
                        throw new Exception('Uri save error', $Uri2->errors);
                }
            }

            foreach ($this->parents as $parentConfig) {
                $parents = $model->{$parentConfig['relation']};
                if (!is_array($parents)) {
                    $parents = [$parents];
                }

                foreach ($parents as $parent) {
                    $routeParams = ['slug'=>$slug];
                    if (isset($parentConfig['params']))
                    foreach ($parentConfig['params'] as $name=>$param) {
                        if (is_numeric($name)) {
                            $name = $param;
                        }
                        if (is_callable($param)) {
                            $param = call_user_func($param, $parent);
                        } else {
                            $param = $parent->{$param};
                        }
                        $routeParams[$name] = $param;
                    }
                    ksort($routeParams);

                    $urisRelationName = ArrayHelper::getValue($parentConfig, 'uriRelation', 'uris');
                    $uris = $parent->getRelation($urisRelationName)->andWhere('redirect_id IS NULL')->all();
                    if (!$uris) {
                        $uris = [new Uri()];
                    }
                    foreach ($uris as $parentUri) {
                        $Uri = $this->makeUrl($parentUri, $routeParams, $model);
                        if ($Uri->isNewRecord) {
                            if (!$Uri->save())
                                throw new Exception('Uri save error', $Uri->errors);

                            $model->link($urisRelationName, $Uri);
                        }
                        elseif ($Uri->redirect_id) {
                            $Uri->redirect_id = null;
                            if (!$Uri->save())
                                throw new Exception('Uri save error', $Uri->errors);
                        }
                        $canonicalUris[$Uri->id] = $Uri;
                    }
                }

                if ($canonicalUris) {
                    // unset created
                    foreach ($canonicalUris as $id=>$v) {
                        unset($canonicalUrisOld[$id]);
                    }
                    // now $canonicalUrisOld - is deleted uris

                    $canonicalUriNew = reset($canonicalUris);

                    // check if old canonical nave not redirect
                    if ($canonicalUriOld) {
                        $canonicalUriOld->refresh();
                        if (!$canonicalUriOld->redirect_id && !isset($canonicalUrisOld[$canonicalUriOld->id])) {
                            $canonicalUriNew = $canonicalUriOld;
                        }
                    }

                    if ($canonicalUrisOld) {
                        // redirect deleted to main URI
                        Uri::updateAll(['redirect_id'=>$canonicalUriNew->id], ['IN', 'id', array_keys($canonicalUrisOld)]);
                    }

                    if ($canonicalUriNew) {
                        Uri::updateAll(['canonical_id'=>$canonicalUriNew->id], ['AND', ['!=', 'id', $canonicalUriNew->id], ['IN', 'id', array_keys($canonicalUris)]]);
                        if ($canonicalUriNew->canonical_id) {
                            $canonicalUriNew->canonical_id = null;
                            if (!$canonicalUriNew->save())
                                throw new Exception('Uri save error', $canonicalUriNew->errors);
                        }
                    }
                }
            }
        } else {
            $urisOld = $model->getRelation($this->uriRelation)->andWhere('redirect_id IS NULL')->all();

            $Uri = $this->makeUrl(null, ['slug'=>$slug], $model);
            if ($Uri->isNewRecord) {
                if (!$Uri->save())
                    throw new Exception('Uri save error', $Uri->errors);

                $model->link($this->uriRelation, $Uri);

                if ($urisOld) {
                    foreach ($urisOld as $uriOld) {
                        $uriOld->redirect_id = $Uri->id;
                        if (!$uriOld->save())
                            throw new Exception('Uri save error', $uriOld->errors);
                    }
                }
            }
            elseif ($Uri->redirect_id) {
                $Uri->redirect_id = null;
                if (!$Uri->save())
                    throw new Exception('Uri save error', $Uri->errors);
            }
        }

        $tx->commit();
    }

    /**
     * @param $parentUri Uri
     * @param $routeParams string[]
     * @param $model ActiveRecord
     * @return Uri
     * @throws Exception
     */
    private function makeUrl($parentUri, $routeParams, $model) {
        if (is_callable($this->route)) {
            $route = call_user_func($this->route, $model);
        } else {
            $route = $this->route;
        }

        $Uri = new Uri();
        $Uri->parent_id = $parentUri ? $parentUri->id : null;
        $Uri->route = $route . '?' . http_build_query($routeParams);
        $Uri->uri = ($parentUri ? $parentUri->uri : '') . '/' . $routeParams['slug'];

        if ($UriFinded = Uri::find()->andWhere(['parent_id'=>$Uri->parent_id, 'route'=>$Uri->route, 'uri'=>$Uri->uri])->one()) {
            return $UriFinded;
        }

        return $Uri;
    }
}