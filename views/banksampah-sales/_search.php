<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BanksampahSalesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banksampah-sales-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'from_banksampah_id') ?>

    <?= $form->field($model, 'to_banksampah_id') ?>

    <?= $form->field($model, 'transaction_date') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'pickup_at') ?>

    <?php // echo $form->field($model, 'vehicle_type') ?>

    <?php // echo $form->field($model, 'nopol') ?>

    <?php // echo $form->field($model, 'pickup_name') ?>

    <?php // echo $form->field($model, 'pickup_description') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
