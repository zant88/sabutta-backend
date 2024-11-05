<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BanksampahSales */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banksampah-sales-form">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'from_banksampah_id')->textInput() ?>

    <?= $form->field($model, 'to_banksampah_id')->textInput() ?>

    <?= $form->field($model, 'transaction_date')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pickup_at')->textInput() ?>

    <?= $form->field($model, 'vehicle_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nopol')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pickup_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pickup_description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
