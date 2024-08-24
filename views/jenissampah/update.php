<?php

use app\models\FasyankesUser;
use app\models\Mbanksampah;
use app\modules\user\models\User;
use yii\helpers\Html;
use kartik\select2\Select2; // or kartik\select2\Select2
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Jenissampah */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
  'modelClass' => 'Jenissampah',
]) . $model->idsampah;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daftar Sampah'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idsampah, 'url' => ['view', 'id' => $model->idsampah]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

// $url = \yii\helpers\Url::to(['fasyankes-user/fasyankes-list']);
$url = \yii\helpers\Url::to(['banksampah/list']);
$user = User::findOne(Yii::$app->user->id);
$bankSampah = Mbanksampah::findOne($user->banksampah_id);
?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->errorSummary($model) ?>
<div class="jenissampah-update">
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
          <?= $this->render('_formUpdate', [
            'model' => $model,
            'mrole' => $mrole,
            'form' => $form
          ]) ?>
        </div>
      </div>
      <?php
      
      if ($bankSampah->parent_id == null || $bankSampah->parent_id == '') {
        ?>
      <div class="card">
        <div class="card-header">
          <h4>Konfigurasi Harga</h4>
        </div>
        <div class="card-body">
          <form>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Nama Vendor / User</label><br />
                  <?=  Select2::widget([
                      'name' => 'vendor_user',
                      'options' => [
                          'id' => 'user-selection',
                          'placeholder' => 'Select vendor / User ...',
                          'multiple' => false
                      ],
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
                        'templateResult' => new JsExpression('function(city) { return city.text; }'),
                        'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                    ],
                  ]);
                  ?>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Harga per KG (Rp)</label>
                  <input type="number" id="amount-price" class="form-control">
                </div>
              </div>
            </div>
            <a href="javascript:void()" id="btn-add" class="btn btn-primary">Tambah</a>
          </form>
          <table class="table mt-4">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Vendor</th>
                <th scope="col">Harga</th>
              </tr>
            </thead>
            <tbody id="detail-addition">
            </tbody>
          </table>
        </div>
      </div>
      <?php 
      }
      ?>  
      <div class="form-group text-right">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
      </div>
        
      
    </div>
    <div class="col-lg-4">
      <h5>Detail</h5>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">User / Vendor</th>
            <th scope="col">Harga</th>
            <th scope="col"></th>
          </tr>
          <?php 
          $data = json_decode($model->json);
          foreach ($data->vendors as $key => $item) {
            ?>
            <tr>
              <td scope="col"><?= $key + 1 ?></td>
              <td scope="col"><?= FasyankesUser::findOne($item->vendorId) != null ? FasyankesUser::findOne($item->vendorId)->namafas : $item->vendorId ?></td>
              <td scope="col"><?= $item->hargaPerKg ? number_format($item->hargaPerKg) : '-' ?></td>
              <td><a class="btn btn-sm btn-danger btn-round" href="javascript:void()">
                <i class="fa fa-trash" aria-hidden=""></i></a>
              </td>
            </tr>
            <?php
          }
          ?>
        </thead>
        <tbody id="detail">
        </tbody>
      </table>
      
    </div>
  </div>
</div>
<?php ActiveForm::end(); ?>

<?php 
$this->registerJsFile(
  'https://unpkg.com/vue@2',
  ['depends' => [\yii\web\JqueryAsset::class]]
);
$this->registerJsFile(
  '//cdn.jsdelivr.net/npm/sweetalert2@11',
  ['depends' => [\yii\web\JqueryAsset::class]]
);
$this->registerJsFile(
  '//cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js',
  ['depends' => [\yii\web\JqueryAsset::class]]
);
?>

<?php
$script = "
var userList = [];
var iAdd = 1;
function numberWithCommas(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, \",\");
}

$('#btn-add').on('click', function(e){
  var id = $('#user-selection').val();
  var amountPrice = $('#amount-price').val();
  var isAdding = true;
  var data = $('#user-selection').select2('data');
  var text = data[0].text;
  var amountPrice = $('#amount-price').val();
  
  userList.forEach(function(item){
    if (item.id == id) {
      isAdding = false;
    }
  });

  if (isAdding) {
    userList.push({id: id, text: text});
    $('#detail-addition').append('<tr><td scope=\"row\">'+iAdd+'</td><td>'+text+'</td><td>'+numberWithCommas(amountPrice)+'</td><input type=\"hidden\" name=\"PriceDetail['+(iAdd-1)+'][id]\" value=\"'+id+'\" /><input type=\"hidden\" name=\"PriceDetail['+(iAdd-1)+'][price]\" value=\"'+amountPrice+'\" /></tr>');
    iAdd++;
    $('#amount-price').val('');
  }else {
    Swal.fire({
      title: 'Error!',
      text: 'User telah ditambahkan!',
      icon: 'error'
    });
  }
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