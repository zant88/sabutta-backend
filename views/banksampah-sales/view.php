<?php

use app\models\Jenissampah;
use app\models\Mbanksampah;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BanksampahSales */

$this->title = $model->code;
$this->params['breadcrumbs'][] = ['label' => 'Daftar Banksampah Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banksampah-sales-view">
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h4>Detail Penjualan</h4>
        </div>
        <div class="card-body">
          <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
              'code',
              [
                'label' => 'From',
                'value' => function ($data) {
                  return $data->fromBanksampah->full_name;
                }
              ],
              // 'from_banksampah_id',
              // 'to_banksampah_id',
              'transaction_date',
              'created_at',
              // 'created_by',
              'status',
              [
                'label' => 'Total',
                'value' => function ($data) {
                  return number_format($data->total);
                }
              ]
              // 'pickup_at',
              // 'vehicle_type',
              // 'nopol',
              // 'pickup_name',
              // 'pickup_description:ntext',
            ],
          ]) ?>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card">
        <div class="card-header">
          <h4>Jual Ke</h4>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="vendor">Vendor</label>
            <select v-model="vendor_comp" class="form-control" @change="onChangeVendor">
              <option>
                - SELECT -
              </option>
              <?php
              foreach ($vendorList as $vendor) {
                ?>
                <option value="<?= $vendor->id ?> - <?= $vendor->phone ?>">
                  <?= $vendor->name ?>
                </option>
                <?php
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>No. Telp</label>
            <input v-model="phone" type="text" class="form-control" />
          </div>
        </div>
      </div>
      <div class="button-container text-right">
        <!-- <a href="javascript:void(0)" class="btn btn-success mr-2">Calculate</a> -->
        <a href="javascript:void(0)" v-if="is_calculate" class="btn btn-primary">Submit</a>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h4>Detail</h4>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive table-invoice">
            <table class="table table-striped">
              <tbody>
                <tr>
                  <th>Sampah</th>
                  <th>Qty (Kg)</th>
                  <th>Harga Beli</th>
                  <th>Harga Jual</th>
                  <th>Total Beli (Rp.)</th>
                  <th>Total Jual (Rp.)</th>
                </tr>
                <tr v-for="item in detail_list" :>
                  <td>{{ item.nama }}</td>
                  <td>{{ item.quantity }}</td>
                  <td>{{ item.purchase_price }}</td>
                  <td>{{ item.selling_price }}</td>
                  <td>{{ item.purchase_total }}</td>
                  <td>{{ item.selling_total }}</td>
                </tr>      
              </tbody>
            </table>
          </div>
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
  window.detailData = <?= json_encode($detailList, JSON_HEX_TAG); ?>;
</script>
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
      onChangeVendor(e) {
        console.log(e.target.value);
        if (e.target.value != '' && e.target.value != '- SELECT -') {
          const arrVendor = e.target.value.split(" - ");
          const vendorId = arrVendor[0];
          const vendorPhone = arrVendor[1];
          this.phone = vendorPhone;
          this.vendor_id = vendorId;
          this.vendor_comp = e.target.value;
          this.getWaste();
          this.is_calculate = true;
        }else {
          console.log('this is executed');
          this.is_calculate = false;
        }
        
      },
      getWaste() {
        axios.get(`/banksampah-sales/calculate/?id=<?= $model->id ?>&vendor_id=${this.vendor_id}`).then(response => {
          const that = this;
          that.detail_list = response.data.data;
        })
      },
      submitSales() {
        const formData = new FormData();
        console.log('this is from sales');
        console.log(this.$refs.sales_date);
        // formData.append('vendor_id', this.vendor_id);
        formData.append('id', this.$refs.sales_date.value);
        formData.append('vendor_id', this.total);
        formData.append('phone', JSON.stringify(this.items));
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        formData.append('_csrf', csrfToken);
        axios.post('/banksampah-sales/submit/', formData).then(response => {
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
      },
    },
    mounted() {
      this.detail_list = window.detailData;
    }
  }).mount('#app');
</script>

<?php $this->endBlock() ?>