<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model app\models\Transaction */
/* @var $form yii\widgets\ActiveForm */

$saveOptions = [
  'type' => 'text', 
  'label'=>'<label>Saved Value: </label>', 
  'class' => 'kv-saved',
  'readonly' => true, 
  'tabindex' => 1000
];
$dispOptions = ['class' => 'form-control kv-monospace'];
$saveCont = ['class' => 'kv-saved-cont'];

$this->registerCssFile("@web/css/daterangepicker.css", [], 'css-print-theme');

$this->registerJsFile(
  '@web/js/moment.js',
  ['depends' => [\yii\web\JqueryAsset::class]]
);

$this->registerJsFile(
  '@web/js/daterangepicker.js',
  ['depends' => [\yii\web\JqueryAsset::class]]
);

?>

<div class="transaction-form">
  <?php $form = ActiveForm::begin(); ?>
  <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->
  <div class="row">
    <div class="col-lg-6">
      <?= $form->field($model, 'type')->dropDownList(
              Yii::$app->params['transaction_type']
      ); ?>
    </div>
    <div class="col-lg-6">
      <?= $form->field($model, 'created_date')->textInput(['class' => 'form-control datepicker']) ?>
    </div>
    
    
    <div class="col-lg-6">
      <?= $form->field($model, 'cash_in')->widget(NumberControl::classname(), [
        'maskedInputOptions' => [
            'prefix' => 'Rp ',
            'allowMinus' => false
        ],
        // 'options' => $saveOptions,
        // 'displayOptions' => $dispOptions,
        // 'saveInputContainer' => $saveCont
      ]);
      ?>
    </div>
    <div class="col-lg-6">
      <?= $form->field($model, 'cash_out')->widget(NumberControl::classname(), [
        'maskedInputOptions' => [
            'prefix' => 'Rp ',
            'allowMinus' => false
        ],
        // 'options' => $saveOptions,
        // 'displayOptions' => $dispOptions,
        // 'saveInputContainer' => $saveCont
      ]);
      ?>
    </div>
    <div class="col-lg-6">
      <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    </div>
    
    
    
  </div>
  <div class="form-group">
      <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>
</div>
