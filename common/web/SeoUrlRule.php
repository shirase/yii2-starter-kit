<?php

namespace common\web;

use common\models\Article;
use common\models\Page;
use common\plugins\page_type\PageTypePlugin;
use yii\web\Request;
use yii\web\UrlManager;
use yii\web\UrlRuleInterface;

class SeoUrlRule implements UrlRuleInterface
{
    private function getPageTypeRoute($page)
    {
        /**
         * @var PageTypePlugin $plugin
         */
        if ($plugin = $page->type->plugin) {
            return [$plugin::route($page), ['slug' => $page->slug, 'category' => $page->id]];
        } else {
            return ['page/view', ['slug' => $page->slug, 'id' => $page->id]];
        }
    }

    /**
     * @param UrlManager $manager
     * @param Request $request
     * @return array|bool
     */
    function parseRequest($manager, $request)
    {
        $pathInfo = trim($request->pathInfo, '/');

        $page = Page::findOne(['slug' => $pathInfo]);
        if ($page) {
            return $this->getPageTypeRoute($page);
        }

        $pathInfoArray = explode('/', $pathInfo);
        if (sizeof($pathInfoArray) < 2) {
            return false;
        }

        $path1 = array_pop($pathInfoArray);
        $category = Page::findOne(['slug' => implode('/', $pathInfoArray)]);
        if ($category) {
            $routeArray = $this->getPageTypeRoute($category);

            if ($routeArray[0] == 'article/index') {
                $model = Article::findOne(['slug' => $path1]);
                if ($model) {
                    return ['article/view', ['slug' => $model->slug, 'category' => $category->id]];
                }
            }
        }

        return false;
    }

    /**
     * @param UrlManager $manager
     * @param string $route
     * @param string[] $params
     * @return bool
     */
    function createUrl($manager, $route, $params)
    {
        $route = trim($route, '/');

        if ($route == 'page/view' || $route == 'article/index') {
            $slug = null;

            if (isset($params['slug'])) {
                $slug = $params['slug'];
                unset($params['slug']);
            } else
                if (isset($params['id'])) {
                    $page = Page::findOne(['id' => $params['id']]);
                    if ($page) {
                        unset($params['id']);
                        $slug = $page->slug;
                    } else {
                        return false;
                    }
                }

            if ($slug) {
                $query = http_build_query($params);
                return $slug . ($query ? '?' . $query : '');
            }
        } elseif ($route == 'article/view') {
            $slug = null;
            $category = null;

            if (isset($params['category'])) {
                if (is_numeric($params['category'])) {
                    $page = Page::findOne(['id' => $params['category']]);
                    if ($page) {
                        $category = $page->slug;
                    } else {
                        return false;
                    }
                } else {
                    $category = $params['category'];
                }
                unset($params['category']);
            }

            if (isset($params['slug'])) {
                $slug = $params['slug'];
                unset($params['slug']);
            } else
                if (isset($params['id'])) {
                    $page = Page::findOne(['id' => $params['id']]);
                    if ($page) {
                        unset($params['id']);
                        $slug = $page->slug;
                    } else {
                        return false;
                    }
                }

            if (isset($params['category'])) {
                $category = Page::findOne(['id' => $params['category']]);
                if ($category) {
                    unset($params['category']);
                }
            }

            if ($slug && $category) {
                $query = http_build_query($params);

                if ($category) {
                    return $category . '/' . $slug . ($query ? '?' . $query : '');
                }

                return $slug . ($query ? '?' . $query : '');
            }
        }

        return false;
    }
}