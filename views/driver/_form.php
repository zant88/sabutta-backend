<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Mbanksampah;

/* @var $this yii\web\View */
/* @var $model app\models\Driver */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="driver-form">
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->
        <div class="row">
            <div class="col-lg-6">
            <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'telpdriver')->textInput(['maxlength' => true, 'placeholder' => '0821xx']) ?>
        </div>
        <?php 
        if (Yii::$app->user->can("admin")) {
            $bsList = Mbanksampah::find()->orderBy('full_name')->all();
            ?>
        <div class="col-lg-6">
            <?= $form->field($model, 'nmperusahaan')->dropDownList($bs_list); ?>
        </div>
            <?php
        }
        ?>
        <?php 
        if ($model->isNewRecord) {
            ?>
        <div class="col-lg-6">
            <?= $form->field($model, 'pass')->textInput(['maxlength' => true, 'readonly' => true, 'value' => 'enviro']) ?>
        </div>
            <?php
        }
        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
