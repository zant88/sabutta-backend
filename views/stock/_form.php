<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Stock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-form">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->

    <?= $form->field($model, 'idstock')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idjnssampah')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nilai')->textInput() ?>

    <?= $form->field($model, 'tgl')->textInput() ?>

    <?= $form->field($model, 'jnsstock')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idorder')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
