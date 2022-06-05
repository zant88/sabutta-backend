<?php

use yii\helpers\Html;

$this->title = 'Laporan Pemasukan';
?>
<!-- <div class="card">
    <div class="card-header">
        <h4><?= Html::encode($this->title) ?></h4>
    </div>  
    <div class="card-body">

    </div>
</div> -->
<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h4>Laporan Pemasukan</h4>
      </div>
      <div id="app">
        <div v-if="is_authenticated == 0" class="card-body">
          <form action="/report/submit-password/" method="post">
            <div class="form-group">
              <label>Password</label>
              <input v-model="password" type="password" class="form-control">
            </div>
            <div class="form-group">
              <a href="javascript:void(0)" @click="submitPassword" class="btn btn-success">Submit</a>
            </div>
          </form>
        </div>
        <div v-if="is_authenticated == 1">
          <div class="container">
            <div class="row">
              <div class="col-lg-4">
                <div class="form-group field-sales-vendor_id required has-error">
                  <label class="control-label" for="sales-vendor_id">Tanggal Awal</label>
                  <input type="text"  class="form-control datepicker" ref="start_date" />
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group field-sales-vendor_id required has-error">
                  <label class="control-label" for="sales-vendor_id">Tanggal Akhir</label>
                  <input type="text" class="form-control datepicker" ref="end_date" />
                </div>
              </div>
              <div class="col-lg-2">
                <div class="form-group field-sales-vendor_id required has-error">
                  <label class="control-label" for="sales-vendor_id">&nbsp;</label>
                  <a href="javascript:void(0)" @click="getIncomeReport" class="btn btn-primary form-control">Cari</a>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Sampah Terpilah</h4>
                    </div>
                    <div class="card-body">
                      {{ waste_amount }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Total Berat (Kg)</h4>
                    </div>
                    <div class="card-body">
                      {{ waste_weight }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Total Penjualan</h4>
                    </div>
                    <div class="card-body">
                      {{ total_sales }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Total Pengeluaran</h4>
                    </div>
                    <div class="card-body">
                      {{ total_cashout }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
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
    '@web/js/views/report.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
  );


  $this->registerJsFile(
    '//cdn.jsdelivr.net/npm/sweetalert2@11',
    ['depends' => [\yii\web\JqueryAsset::class]]
  );

  $this->registerJsFile(
    '@web/js/daterangepicker.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
  );
  ?>