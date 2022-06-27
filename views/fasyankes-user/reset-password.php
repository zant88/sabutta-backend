<?php

use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;
use app\models\FasyankesUser;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FasyankesUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Reset Password');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fasyankes-user-index">
  <?php Pjax::begin(); ?>
  <?php // echo $this->render('_search', ['model' => $searchModel]); 
  ?>

  <div class="card">
    <div class="card-header">
      <h4><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="card-body">
<?php 
  //use app\models\Country;
$users=FasyankesUser::find()->all();

//use yii\helpers\ArrayHelper;
$listData=ArrayHelper::map($users, 'idfas','namafas');
?>
      <select class="form-control" id="user">
        <?php
        foreach ($users as $item) {
        ?>
          <option value="<?= $item->idfas ?>"><?= $item->namafas ?></option>
        <?php
        }
        ?>
      </select>
      <p>
        <?= Html::a(Yii::t('app', 'Reset Password'), ['reset-password'], ['class' => 'btn btn-success', 'id'=>'btn-reset']) ?>
      </p>
    </div>
  </div>
  <?php Pjax::end(); ?>
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
    }, 1000);
    $('#btn-reset').on('click', function(e){
      e.preventDefault();
      $.ajax({
        url: '/fasyankes-user/reset-password',
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
            window.location.href = '/fasyankes-user/';
          });
        } 
      });
    });
    
  });", \yii\web\View::POS_READY
);
?>