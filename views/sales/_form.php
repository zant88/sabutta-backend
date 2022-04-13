<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Sales */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model) ?>
    <!-- ADDED HERE -->
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'vendor_id')->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'sales_date')->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'total')->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>
        </div>
    </div>    
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>