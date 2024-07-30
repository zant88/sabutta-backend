<?php

use app\models\Jenissampah;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('app', 'Sales Baru');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daftar Sales'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-create">
  <div id="app">
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header">
            <h4><?= Html::encode($this->title) ?></h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group field-sales-vendor_id required has-error">
                  <label class="control-label" for="sales-vendor_id">Tanggal Penjualan</label>
                  <input type="text" class="form-control datepicker" ref="sales_date" />
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group field-sales-vendor_id required has-error">
                  <div class="form-group">
                    <label>Vendor</label>
                    <select v-model="vendor_id" class="form-control" @change="getWaste">
                      <?php
                      foreach ($vendor as $item) {
                      ?>
                        <option value="<?= $item->id ?>"><?= $item->name ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <!-- <input type="text" id="sales-vendor_id" class="form-control" name="Sales[vendor_id]" aria-required="true" aria-invalid="true"> -->
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <div class="container-header d-flex">
              <h4>Detail Sampah</h4>
              <!-- <a href="javacript:void(0)" class="btn btn-primary daterange-btn icon-left btn-icon" data-toggle="modal" data-target="#exampleModal">
                <i class="fas fa-plus"></i>
              </a> -->
            </div>
          </div>
          <div class="card-body">
            <div class="input-container-sales">
              <div class="sampah-container">
                <label class="control-label">Sampah</label>
                <select class="form-control" ref="jenissampah">
                  <option v-for="item in waste_list" :value="item.id">{{ item.waste_name }}</option>
                </select>
              </div>
              <div class="form-group amount-container">
                <label>Berat</label>
                <div class="input-group">
                  <input v-model="weight" type="text" class="form-control currency">
                </div>
              </div>
              <div class="form-group add-container">
                <a href="javascript:void(0)" v-on:click="add()" class="btn btn-primary"><i class="fas fa-check"></i> Add</a>
              </div>
            </div>
            <table class="table table-striped table-md">
              <tbody>
                <tr>
                  <th>#</th>
                  <th>Nama Sampah</th>
                  <th>Berat (Kg)</th>
                  <th>Harga Satuan</th>
                  <th>Total</th>
                  <th></th>
                </tr>
                <tr v-for="(item, i) in items">
                  <td>{{ i+1 }}</td>
                  <td>{{ item.name }}</td>
                  <td>{{ item.weight }}</td>
                  <td>Rp. {{ item.harga }}</td>
                  <td>Rp. {{ item.total }}</td>
                  <td>
                    <a href="javacript:void(0)" v-on:click="remove(i)">
                      <i class="fas fa-trash"></i>
                  </td>
                  </a>
                </tr>

              </tbody>
            </table>
            <br />
            <br />
            <div class="totalc-container row">
              <div class="col-lg-8">
                <p class="total-footer-label">Total</p>
              </div>
              <div class="col-lg-4">
                <p class="total-footer-value">Rp. {{ numberWithCommas(total) }}</p>
              </div>
            </div>
            <br />
            <a class="btn btn-primary" v-on:click="save()">Simpan</a>
          </div>
        </div>
      </div>
      <!-- <div class="col-lg-4">
        <h5>Harga jual Botol C3</h5>
        <h6>Stok : 1000 Kg</h6>
        <div class="table-responsive">
          <table class="table table-bordered table-md">
            <tbody>
              <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Harga</th>
              </tr>
              <tr>
                <td>1</td>
                <td>Vendor 1</td>
                <td>Rp. 2.000.000</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Vendor 2</td>
                <td>Rp. 200.000</td>
              </tr>
              <tr>
                <td>3</td>
                <td>Vendor 3</td>
                <td>Rp. 100.000</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div> -->
    </div>
  </div>
</div>
<?php


$this->registerCssFile("@web/css/daterangepicker.css", [], 'css-print-theme');

$this->registerJsFile(
  'https://unpkg.com/vue@2',
  ['depends' => [\yii\web\JqueryAsset::class]]
);

$this->registerJsFile(
  '@web/js/moment.js',
  ['depends' => [\yii\web\JqueryAsset::class]]
);

$this->registerJsFile(
  '@web/js/daterangepicker.js',
  ['depends' => [\yii\web\JqueryAsset::class]]
);

$this->registerJsFile(
  'https://unpkg.com/select2@4.0.3/dist/js/select2.js',
  ['depends' => [\yii\web\JqueryAsset::class]]
);

$this->registerJsFile(
  '@web/js/views/sales.js',
  ['depends' => [\yii\web\JqueryAsset::class]]
);

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
    // setTimeout(function() {
      // $('#jenissampah').select2();
    // }, 1000);
});", \yii\web\View::POS_READY
);
?>

<?php $this->beginBlock('modal') ?>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<?php $this->endBlock() ?>