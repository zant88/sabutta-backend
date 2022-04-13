<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\JenissampahSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jenissampah-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'idsampah') ?>

    <?= $form->field($model, 'nama') ?>

    <?= $form->field($model, 'hargaperkg') ?>

    <?= $form->field($model, 'desc') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'roleuser') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
