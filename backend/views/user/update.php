<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\models\UserForm */
/* @var $roles yii\rbac\Role[] */

$this->title = Yii::t('backend', 'Update: ', ['modelClass' => 'User']) . ' ' . $model->getUser()->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Update')];
?>
<div class="user-update">
    <?php echo $this->render('_form', [
        'model' => $model,
        'roles' => $roles
    ]) ?>
</div>
