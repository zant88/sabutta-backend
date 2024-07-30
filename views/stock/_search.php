<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\export\ExportMenu;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\StockSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-search">

  <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'options' => [
      'data-pjax' => 1,
      'id' => 'frm-search'
    ],
  ]); ?>

  <div class="row">
    <div class="col-lg-6">
      <?= $form->field($model, 'startDate')->textInput(['class' => 'form-control datepicker']) ?>
    </div>
    <div class="col-lg-6">
      <?= $form->field($model, 'endDate')->textInput(['class' => 'form-control datepicker']) ?>
    </div>
    <div class="col-lg-6">
      <?= $form->field($model, 'jnsstock')->dropDownList(
        [
          'IN' => 'MASUK',
          'OUT' => 'KELUAR'
        ],
        ['prompt' => 'Keluar / Masuk']
      ); ?>
    </div>
    <div class="col-lg-6">
      <?= $form->field($model, 'wasteName') ?>
    </div>
    <div class="col-lg-6">
      <?= $form->field($model, 'trxType')->dropDownList(
        [
          'BANK SAMPAH' => 'BANK SAMPAH',
          'TPST-GABRUKAN' => 'TPST GABRUKAN',
          'TPST-TERPILAH' => 'TPST TERPILAH',
        ],
        ['prompt' => 'Jenis Transaksi']
      ); ?>
    </div>
    <!-- <div class="col-lg-6">
            <?= $form->field($model, 'trxType') ?>
        </div> -->
    <div class="col-lg-6">
      <?= $form->field($model, 'userName') ?>
    </div>
  </div>

  <?php // echo $form->field($model, 'idorder') 
  ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>


<?php
$script = "
$('#frm-search').submit(function( event ) {
    console.log('test');
    setTimeout(function() {
        $('.datepicker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
    }, 1000);
    event.preventDefault();
  });

  
  ";
$this->registerJs(
  $script,
  View::POS_READY,
  'my-button-handler'
);
?>