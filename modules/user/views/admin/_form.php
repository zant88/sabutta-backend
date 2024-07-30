<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var amnah\yii2\user\Module $module
 * @var amnah\yii2\user\models\User $user
 * @var amnah\yii2\user\models\Profile $profile
 * @var amnah\yii2\user\models\Role $role
 * @var yii\widgets\ActiveForm $form
 */

$module = $this->context->module;
$role = $module->model("Role");
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
    ]); ?>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($profile, 'full_name'); ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($user, 'email')->textInput(['maxlength' => 255]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($user, 'username')->textInput(['maxlength' => 255]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($user, 'newPassword')->passwordInput() ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($user, 'role_id')->dropDownList($role::dropdown()); ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($user, 'status')->dropDownList($user::statusDropdown()); ?>
        </div>
        <?php 
        if (!$user->isNewRecord) {
            ?>
        <div class="col-lg-6">
            <?php // use checkbox for banned_at ?>
            <?php // convert `banned_at` to int so that the checkbox gets set properly ?>
            <?php $user->banned_at = $user->banned_at ? 1 : 0 ?>
            <?= Html::activeLabel($user, 'banned_at', ['label' => Yii::t('user', 'Banned')]); ?>
            <?= Html::activeCheckbox($user, 'banned_at'); ?>
            <?= Html::error($user, 'banned_at'); ?>

            <?= $form->field($user, 'banned_reason'); ?>
        </div>
            <?php
        }
        ?>
        
    </div>
    <div class="form-group">
        <?= Html::submitButton($user->isNewRecord ? Yii::t('user', 'Create') : Yii::t('user', 'Update'), ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
