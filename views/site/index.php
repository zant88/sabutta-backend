<?php
use yii\web\View;

/** @var yii\web\View $this */

$this->title = 'Sabutta Dashboard';
?>
<div class="site-index">

  <div class="body-content">
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="far fa-user"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total BS User</h4>
            </div>
            <div class="card-body" id="total-bs">
              -
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
              <h4>Penjualan Bulan Ini</h4>
            </div>
            <div class="card-body" >
              Rp. <span id="total-sales"></span>,-
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
              <h4>Nominal Sampah Bulan Ini</h4>
            </div>
            <div class="card-body">
              Rp. 100.000.000,-
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
              <h4>Berat Terpilah Bulan Ini</h4>
            </div>
            <div class="card-body">
              47
            </div>
          </div>
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
        url: '/site/get-total-user/',
        success: function(data){
            $('#total-bs').text(numberWithCommas(data.data));
        }
    });
    $.ajax({
        url: '/site/get-total-sales/',
        success: function(data){
            console.log(data.data);
            $('#total-sales').text(numberWithCommas(data.data));
        }
    });
    ",
    View::POS_READY,
    'aggregate-function'
);
?>