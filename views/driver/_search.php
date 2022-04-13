<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DriverSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="driver-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'iddriver') ?>

    <?= $form->field($model, 'nama') ?>

    <?= $form->field($model, 'nmperusahaan') ?>

    <?= $form->field($model, 'telppersh') ?>

    <?= $form->field($model, 'telpdriver') ?>

    <?php // echo $form->field($model, 'lat') ?>

    <?php // echo $form->field($model, 'lon') ?>

    <?php // echo $form->field($model, 'sts') ?>

    <?php // echo $form->field($model, 'stsjob') ?>

    <?php // echo $form->field($model, 'foto') ?>

    <?php // echo $form->field($model, 'userid') ?>

    <?php // echo $form->field($model, 'pass') ?>

    <?php // echo $form->field($model, 'tokenfb') ?>

    <?php // echo $form->field($model, 'role') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
