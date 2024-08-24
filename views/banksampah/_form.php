<?php

use app\models\Mbanksampah;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Mbanksampah */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mbanksampah-form">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->errorSummary($model) ?>
        <div class="row">
            <div class="col-lg-6">
                <?= $form->field($model, 'banksampahid')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-12">
                <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
            </div>
            <?php 
            if (Yii::$app->user->can("admin")) {
                $bsList = Mbanksampah::find()->orderBy('full_name')->all();
                ?>
            <div class="col-lg-6">
                <?= $form->field($model, 'parent_id')->dropDownList(
                    ArrayHelper::map($bsList, 'id', 'full_name'),
                    ['prompt' => 'Pilih nama bank sampah!']
                ); ?>
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
