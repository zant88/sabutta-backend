<?php 
use yii\helpers\Html;
use app\modules\user\models\User;


$this->title = Yii::t('app', 'Stock Opname');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="stock-opname">
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
          <form>
            <div class="form-group">
              <label>Waste</label>
              <select id="waste_id" @change="getCurrentStock" v-model="waste_id" class="custom-select">
                <option selected="">- PILIH -</option>
                <?php 
                foreach ($waste as $item) {
                  ?>
                  <option value="<?= $item->idsampah ?>"><?= $item->nama ?></option>
                  <?php
                }
                ?>
              </select>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Jumlah Penambahan/Pengurangan Stok (Kg)</label>
                  <input v-model="increment_stock" type="number" class="form-control" placeholder="Jumlah penambahan stock dalam satuan KG">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Stok saat ini </label>
                  <input type="text" read class="form-control" v-model="curr_stock" readonly disabled  placeholder="0">
                </div>
              </div>
            </div>
            
            <a class="btn btn-primary mr-1" @click="submit">Simpan</a>
          </form>
        </div>
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
        waste_id: '',
        increment_stock: 0,
        curr_stock: 0
      }
    },
    methods: {
      formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      },
      getCurrentStock() {
        axios.get(`/stock/get-stock/?waste_id=${this.waste_id}`).then(response => {
          this.curr_stock = response.data;
        });
      },
      submit() {
        if (this.waste_id == '') {
          Swal.fire({
            title: 'Error!',
            text: 'Anda belum memilih sampah!',
            icon: 'error',
            confirmButtonText: 'Ok'
          });
        }else if (this.increment_stock == '' || this.increment_stock == 0) {
          Swal.fire({
            title: 'Error!',
            text: 'Anda belum memasukan stok',
            icon: 'error',
            confirmButtonText: 'Ok'
          });
        } else {
          Swal.fire({
            icon: 'question',
            title: 'Anda yakin akan melakukan proses stock opname?',
            showCancelButton: true,
            confirmButtonText: 'Yes',
          }).then((result) => {
            if (result.isConfirmed) {
              const formData = new FormData();
              formData.append('waste_id', this.waste_id);
              formData.append('weight', this.increment_stock);
              var csrfToken = $('meta[name="csrf-token"]').attr("content");
              formData.append('_csrf', csrfToken);
              axios.post('/stock/stock-opname/', formData).then(response => {
                console.log(response.data);
                if (response.data.success == true) {
                  Swal.fire({
                    title: 'Sukses!',
                    text: 'Stock Opname telah berhasil dilakukan!',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                  }).then(() => {
                    window.location.href = '/stock/';
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

<?php
$this->registerJsFile(
  'https://unpkg.com/select2@4.0.3/dist/js/select2.js',
  ['depends' => [\yii\web\JqueryAsset::class]]
);

// $this->registerJs(
//   "$(document).ready(function() {
//     setTimeout(function(){
//       $('#waste_id').select2();
//     }, 2000);
//   });", \yii\web\View::POS_READY
// );
?>