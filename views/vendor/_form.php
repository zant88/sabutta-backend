<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Vendor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vendor-form">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->
        <div class="row">
            <div class="col-lg-6">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'address')->textarea(['rows' => 6, 'cols' => 50]) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'description')->textarea(['rows' => 6], ['rows'=>4]) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'percentage_profit')->textInput([
                    'type' => 'number',       // Use 'number' type to allow only numeric input
                    'step' => '0.01',         // Set the step to allow decimal values (e.g., 0.01 for 2 decimal places)
                    'min' => '0',             // Optional: Set minimum value if needed
                    'max' => '100',
                    'placeholder' => 'Masukan nilai prosentasi keuntungan'
                ])->label('Prosentasi Keuntungan') ?>
            </div>
            
            <div class="col-lg-6">
                <?= $form->field($model, 'status')->dropDownList(
                    [true => 'Aktif', false => 'Tidak Aktif']
                ); ?>
            </div>
        </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
