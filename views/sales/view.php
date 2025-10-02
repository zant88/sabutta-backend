<?php

use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Sales */

$this->title = $model->code;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daftar Sales'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
  ['class' => 'yii\grid\SerialColumn'],
  [
    'label' => 'Sampah',
    'value' => function ($model) {
      return $model->waste->nama;
    }
  ],
  'amount_kg',
  'total_price',
  // 'status',

];
?>
<div class="sales-view">
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group field-sales-vendor_id">
                <label class="control-label">Tanggal Penjualan</label>
                <input type="text" class="form-control" disabled value="<?= $model->sales_date ?>" />
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group field-sales-vendor_id">
                <label class="control-label">Vendor</label>
                <input type="text" class="form-control" disabled value="<?= $model->vendor->name ?>" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
          ]); ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-8">
    <?= Html::a(Yii::t('app', 'Buat/Edit Surat Jalan'), ['surat-jalan', 'id' => $model->id], ['class' => 'btn btn-success mr-2']) ?>
    <?= Html::a(Yii::t('app', 'Print Surat Jalan'), ['print-surat-jalan', 'id' => $model->id], ['class' => 'btn btn-primary mr-2']) ?>
    <?php 
    if (!Yii::$app->user->can('admin')) {
      ?>
      <a href="javascript:void(0)" @click="dispatchWaste" class="btn btn-dark">Sampah Diangkut?</a>
      <?php 
    }
    ?>
    
  </div>
</div>

<?php $this->beginBlock('scripts') ?>
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
  const {
    createApp,
    ref,
    toRaw
  } = Vue;

  createApp({
    data() {
      return {
        phone: '',
        vendor_id: '',
        detail_list: [],
        vendor_comp: '',
        is_calculate: false,
      }
    },
    methods: {
      dispatchWaste() {
        Swal.fire({
          icon: 'question',
          title: 'Anda yakin akan melakukan proses pengangkutan sampah? Dengan menekan tombol ya, maka stok otomatis akan berkurang!',
          showCancelButton: true,
          confirmButtonText: 'Yes',
        }).then((result) => {
          if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('id', <?= $model->id ?>);
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            formData.append('_csrf', csrfToken);
            axios.post('/banksampah-sales/dispatch-waste/', formData).then(response => {
              console.log(response.data);
              if (response.data.success == true) {
                Swal.fire({
                  title: 'Sukses!',
                  text: 'Sampah telah berhasil dikirim ke vendor!',
                  icon: 'success',
                  confirmButtonText: 'Ok'
                }).then(() => {
                  window.location.href = '/banksampah-sales/';
                });
              }
            });
          }
        });
      },
    },
  }).mount('#app');
</script>

<?php $this->endBlock() ?>