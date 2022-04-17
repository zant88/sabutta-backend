<?php

use app\models\WasteType;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Jenissampah */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jenissampah-form">

  <?php $form = ActiveForm::begin(); ?>
  <?= $form->errorSummary($model) ?>
  <!-- ADDED HERE -->
  <div class="row">
    <div class="col-lg-6">
      <?= $form->field($model, 'idsampah')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-6">
      <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-6">
      <?= $form->field($model, 'hargaperkg')->textInput() ?>
    </div>
    <div class="col-lg-6">
      <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-6">
      <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-6">
      <?= $form->field($model, 'roleuser')
        ->dropDownList(
          ArrayHelper::map($mrole, 'idrole', 'namarole'),
          ['prompt' => '', 'id' => 'roleuser_id']
        ); ?>
    </div>
    <div class="col-lg-6">
      <?php
      $wasteType = WasteType::find()->orderBy('name')->all();
      ?>
      <?= $form->field($model, 'waste_type_id')
        ->dropDownList(
          ArrayHelper::map($wasteType, 'id', 'name'),
          ['prompt' => '', 'id' => 'waste_type_id']
        ); ?>
    </div>
  </div>
  <div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJsFile(
  'https://unpkg.com/select2@4.0.3/dist/js/select2.js',
  ['depends' => [\yii\web\JqueryAsset::class]]
);

$this->registerJs(
  "$(document).ready(function() {
    $('#waste_type_id').select2();
    // $('#roleuser_id').select2();
  });", \yii\web\View::POS_READY
);
?>