<?php

use app\models\WasteType;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Jenissampah */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jenissampah-form">


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
      <?= $form->field($model, 'status')
        ->dropDownList(
          ['AKTIF' => 'AKTIF', 'NON AKTIF' => 'NON AKTIF'],
          ['prompt' => '', 'id' => 'waste_type_id']
        ); ?>
    </div>
    <!-- <div class="col-lg-6">
      <?= 
      $form->field($model, 'roleuser')->widget(Select2::classname(), [
        'data' => ArrayHelper::map($mrole, 'idrole', 'namarole'),
        'options' => ['placeholder' => 'Select a state ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true
        ],
    ]);
      ?>
     
    </div> -->
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