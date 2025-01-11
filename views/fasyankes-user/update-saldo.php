<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FasyankesUser */

$this->title = Yii::t('app', 'Update Pengguna: ', [
    'modelClass' => 'User',
]) . $model->idfas;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daftar Pengguna'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Update Pengguna'), 'url' => 'update?id='.$model->idfas ];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update Saldo');
?>

<div class="row">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h4>Saldo Saat Ini</h4>
      </div>
      <div class="card-body">
        <div class="current-balance">
          <h3>Rp. <?= number_format($model->saldo) ?></h3>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h4>Update Saldo</h4>
      </div>
      <div class="card-body">
        <?php $form = ActiveForm::begin(['id'=>'form-user']); ?>
        <?= $form->field($model, 'saldo')->textInput(['maxlength' => true]) ?>
        <div class="form-group">
          <!-- <a href="javascript:void()" class="btn btn-primary">Update</a> -->
          <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
      </div>
    </div>
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
      formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      },
      submitSales() {
        if (this.phone == '') {
          Swal.fire({
            title: 'Error!',
            text: 'Anda belum memasukan no telp!',
            icon: 'error',
            confirmButtonText: 'Ok'
          });
        } else {
          Swal.fire({
            icon: 'question',
            title: 'Anda yakin akan melakukan proses penjualan?',
            showCancelButton: true,
            confirmButtonText: 'Yes',
          }).then((result) => {
            if (result.isConfirmed) {
              const formData = new FormData();
              formData.append('id', <?= $model->idfas ?>);
              formData.append('vendor_id', this.vendor_id);
              formData.append('phone', this.phone);
              var csrfToken = $('meta[name="csrf-token"]').attr("content");
              formData.append('_csrf', csrfToken);
              axios.post('/banksampah-sales/sell-to-vendor/', formData).then(response => {
                console.log(response.data);
                if (response.data.success == true) {
                  Swal.fire({
                    title: 'Sukses!',
                    text: 'Data telah berhasil disimpan!',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                  }).then(() => {
                    window.location.href = '/banksampah-sales/';
                  });
                }
              });
            }
          });
        }
      },
    },
  }).mount('#app');
</script>

<?php $this->endBlock() ?>