<?php
use yii\web\View;

/** @var yii\web\View $this */

$this->title = 'Sabutta Dashboard';
?>
<div class="row">
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-primary">
        <i class="far fa-user"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Berat Sampah (Kg) Hari ini</h4>
        </div>
        <div id="today-weight" class="card-body">
          0
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-danger">
        <i class="far fa-newspaper"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Bagi Hasil Hari ini</h4>
        </div>
        <div id="today-trx-fee" class="card-body">
          Rp. 0
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-warning">
        <i class="far fa-file"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Total Berat Bulan Ini (Kg)</h4>
        </div>
        <div id="this-month-weight" class="card-body">
          0 Kg
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-success">
        <i class="fas fa-circle"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Total Bagi Hasil Bulan Ini</h4>
        </div>
        <div id="this-month-trx-fee" class="card-body">
          Rp. 0
        </div>
      </div>
    </div>
  </div>                  
</div>

<?php 
$this->registerJs(
    "function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }",
    View::POS_READY,
    'util-function'
);
$this->registerJs(
    "
    $.ajax({
        url: '/site/get-today-weight/',
        success: function(data){
          $('#today-weight').text(numberWithCommas(data.data));
        }
    });
    $.ajax({
        url: '/site/get-this-month-weight/',
        success: function(data){
          $('#this-month-weight').text(`Rp. \${numberWithCommas(data.data)}`);
        }
    });
    $.ajax({
        url: '/site/get-today-transaction-fee/',
        success: function(data){
          $('#today-trx-fee').text(`Rp. \${numberWithCommas(data.data)}`);
        }
    });
    $.ajax({
        url: '/site/get-this-month-transaction-fee/',
        success: function(data){
          $('#this-month-trx-fee').text(`Rp. \${numberWithCommas(data.data)}`);
        }
    });
    ",
    View::POS_READY,
    'aggregate-function'
);
?>