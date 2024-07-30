<?php

use app\models\Order;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\OrderRevision */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-revision-form">

  
  <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->

  <!-- <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?> -->
  <?php
  $data = [];
  $url = \yii\helpers\Url::to(['sales/order-list']);
  if (!$model->isNewRecord) {
    $dataList = Order::find()->andWhere(['idorder' => $model->idorder])->all();
    $data = ArrayHelper::map($dataList, 'idorder', 'idorder');
  }
  // this is WIP
  echo $form->field($model, 'order_id')->widget(Select2::classname(), [
    'data' => $data,
    'options' => ['placeholder' => 'Search for a order ...', 'id' => 'order_id'],
    'pluginOptions' => [
      'allowClear' => true,
      'minimumInputLength' => 1,
      'language' => [
        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
      ],
      'ajax' => [
        'url' => $url,
        'dataType' => 'json',
        'data' => new JsExpression('function(params) { return {q:params.term}; }')
      ],
      'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
      'templateResult' => new JsExpression('function(item) { return item.text; }'),
      'templateSelection' => new JsExpression('function (item) { return item.text; }'),
    ],
  ]);
  ?>
  <!-- <?= $form->field($model, 'order_id')->textInput(['maxlength' => true]) ?> -->

  <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

  <?= $form->field($model, 'revision_date')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Enter request date'],
    'pluginOptions' => [
      'autoclose' => true,
      'format' => 'yyyy-mm-dd'
    ]
  ]); ?>

  <div class="form-group">
    
  </div>

</div>

<?php
$script = "
var wasteList = [];
var iAdd = 1;
function numberWithCommas(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, \",\");
}

$('#order_id').on('select2:select', function(e){
  console.log(e.target.value);
  $.ajax({
    'url': '/sales/order-detail',
    'data': {
      'id': e.target.value
    },
    success: function(data) {
      console.log(data)
      $('#detail *').remove();
      $('#waste-selection *').remove();
      var i = 1;
      wasteList = data.results;
      data.results.forEach((item) =>{
        $('#detail').append('<tr><th scope=\"row\">'+i+'</th><td>'+item.nama+'</td><td>'+numberWithCommas(item.berat)+' kg</td><td>'+numberWithCommas(item.harga)+'</td></tr>');
        $('#waste-selection').append('<option value='+item.idsampah+'>'+item.nama+'</option>');
        i++;
      });
    }
  });
});

$('#btn-add-revision').on('click', function(e){
  console.log('test click');
  var id = $('#waste-selection').val();
  // console.log(id);
  wasteList.forEach(function(item){
    console.log(item.sampah);
    if (item.idsampah == id) {
      var weight = parseInt($('#amount-weight').val());
      console.log('this is test');
      if (weight <= item.berat) {
        $('#detail-addition').append('<tr><th scope=\"row\">'+iAdd+'</th><td>'+item.nama+'</td><td>'+numberWithCommas(weight)+' kg</td><input type=\"hidden\" name=\"RevisionDetail['+(iAdd-1)+'][idsampah]\" value=\"'+id+'\" /><input type=\"hidden\" name=\"RevisionDetail['+(iAdd-1)+'][berat]\" value=\"'+weight+'\" /></tr>');
        iAdd++;
      }else {
        Swal.fire({
          title: 'Error!',
          text: 'Jumlah perubahan tidak boleh lebih daripada transaksi setoran!',
          icon: 'error'
        });
      }
    }
  });
});

function validateForm() {
  var ret = false;
  if ($('#orderrevision-description').val() == '') {
    Swal.fire({
      title: 'Error!',
      text: 'Masukan deskripsi koreksi!',
      icon: 'error'
    });
  }else if ($('#orderrevision-revision_date').val() == '') {
    Swal.fire({
      title: 'Error!',
      text: 'Masukan tanggal koreksi!',
      icon: 'error'
    });
  }else if (iAdd == 0) {
    Swal.fire({
      title: 'Error!',
      text: 'Masukan item sampah yang mau direvisi!',
      icon: 'error'
    });
  }else {
    ret = true;
  }

  return ret;
}

$('#order-revision').on('submit', function(e){
  if (validateForm()) {
    return;
  }
  e.preventDefault();
})
";

$this->registerJs(
  $script,
  View::POS_READY,
  'my-button-handler'
);
?>