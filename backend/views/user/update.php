<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\models\UserForm */
/* @var $roles yii\rbac\Role[] */

$this->title = Yii::t('backend', 'Update: ', ['modelClass' => 'User']) . ' ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Profile'), 'url' => ['sign-in/profile', 'id' => $model->getModel()->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Update')];
?>
<div class="clearfix">
    <?= Html::a(Yii::t('backend', 'Profile'), ['sign-in/profile', 'id'=>$model->getModel()->id], ['class'=>'pull-right btn btn-info btn-xs']) ?>
</div>
<div class="user-update">
    <?php echo $this->render('_form', [
        'model' => $model,
        'roles' => $roles
    ]) ?>
</div>
