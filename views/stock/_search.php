<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $model app\models\StockSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'startDate') ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'endDate') ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'jnsstock')->dropDownList(
                [
                    'IN' => 'MASUK',
                    'OUT' => 'KELUAR'
                ], 
                ['prompt'=>'Keluar / Masuk']); ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'wasteName') ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'trxType') ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'userName') ?>
        </div>
    </div>
    

    
    <?php // echo $form->field($model, 'idorder') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
