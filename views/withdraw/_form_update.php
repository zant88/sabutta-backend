<?php

use yii\helpers\Html;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\FasyankesUser;
use kartik\date\DatePicker;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Withdraw */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="withdraw-form">
  <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->
  <div class="row">
    <div class="col-lg-6">
      <p>ID Requester</p>
    </div>
    <div class="col-lg-6">
      <p><?= $model->idfas ?></p>
    </div>
    <div class="col-lg-6">
      <p>Nama</p>
    </div>
    <div class="col-lg-6">
      <p><?= $model->customer->namafas ?></p>
    </div>
    <div class="col-lg-6">
      <p>Bank</p>
    </div>
    <div class="col-lg-6">
      <p><?= $model->bank->keterangan ?></p>
    </div>
    <div class="col-lg-6">
      <p>A.N</p>
    </div>
    <div class="col-lg-6">
      <p><?= $model->bank->namabank ?></p>
    </div>
    <div class="col-lg-6">
      <p>No Rekening</p>
    </div>
    <div class="col-lg-6">
      <p><?= $model->bank->norekening ?></p>
    </div>
    <div class="col-lg-6">
      <p>Request Date</p>
    </div>
    <div class="col-lg-6">
      <p><?= $model->request_date ?></p>
    </div>
  </div>
        <div class="row">
          <div class="col-lg-6">
            <?= $form->field($model, 'amount')->textInput() ?>
          </div>
          <div class="col-lg-6">
            <?= $form->field($model, 'status')->dropDownList([
                  'requested' => 'Requested', 'transferred' => 'Transferred'],['prompt'=>'Select Status']);
            ?>
          </div>
          <div class="col-lg-6">
          <?= $form->field($model, 'transfer_date')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Enter transfer date'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]); ?>
          </div>
        </div>
</div>

<?php 
$script = "
$('#idfas').on('select2:select', function(e){
  console.log(e.target.value);
  $.ajax({
    'url': '/fasyankes-user/bank-list',
    'data': {
      'id': e.target.value
    },
    success: function(data) {
      console.log(data)
      data.forEach((item) =>{
        $('#bank-id').append('<option value='+item.idbank+'>'+item.text+'</option>')
      });
      
    }
  });
})";
$this->registerJs(
    $script,
    View::POS_READY,
    'my-button-handler'
);
?>