<?php

use app\models\Driver;
use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;
use app\models\FasyankesUser;
use app\models\Mbanksampah;
use app\modules\user\models\User;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FasyankesUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Reset Password');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="driver-index">
  <!-- <?php Pjax::begin(); ?> -->
  <?php // echo $this->render('_search', ['model' => $searchModel]); 
  ?>

  <div class="card">
    <div class="card-header">
      <h4><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="card-body">
    <p>Password akan kembali menjadi "enviro"</p>
<?php 
  //use app\models\Country;
  if (Yii::$app->user->can('admin')) {
    $users=Driver::find()->all();
  }else {
    $user = User::findOne(Yii::$app->user->id);
    $bankSampah = Mbanksampah::findOne($user->banksampah_id);
    $users=Driver::find()->where([
      'nmperusahaan' => $bankSampah->banksampahid
    ])->all();
  }
  //use yii\helpers\ArrayHelper;
  $listData=ArrayHelper::map($users, 'idfas','namafas');
?>
      <select class="form-control" id="user">
        <?php
        foreach ($users as $item) {
        ?>
          <option value="<?= $item->iddriver ?>"><?= $item->nama ?></option>
        <?php
        }
        ?>
      </select>
      <p>
        <?= Html::a(Yii::t('app', 'Reset Password'), ['reset-password'], ['class' => 'btn btn-success mt-3', 'id'=>'btn-reset']) ?>
      </p>
    </div>
  </div>
  <!-- <?php Pjax::end(); ?> -->
</div>

<?php 
$this->registerJsFile(
  'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
  ['depends' => [\yii\web\JqueryAsset::class]]
);

$this->registerJsFile(
  '//cdn.jsdelivr.net/npm/sweetalert2@11',
  ['depends' => [\yii\web\JqueryAsset::class]]
);

$this->registerJs(
  "$(document).ready(function() {
    var csrfToken = $('meta[name=\"csrf-token\"]').attr(\"content\");
    setTimeout(function(){
      $('#user').select2();
    }, 500);
    $('#btn-reset').on('click', function(e){
      e.preventDefault();
      if ($('#user').val() != '') {
        $.ajax({
          url: '/driver/reset-password',
          type: 'POST',
          data: {
            id: $('#user').val(),
            _csrf: csrfToken
          },
          success: function(data) {
            Swal.fire({
              title: 'Sukses!',
              text: 'Password telah berhasil direset!',
              icon: 'success',
              confirmButtonText: 'Ok'
            }).then(() => {
              window.location.href = '/driver/';
            });
          } 
        });
      }else {
        Swal.fire({
          title: 'Gagal',
          text: 'Silakan pilih pengguna untuk direset!',
          icon: 'error',
          confirmButtonText: 'Ok'
        })
      }
    });
    
  });", \yii\web\View::POS_READY
);
?>