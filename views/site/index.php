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
<div class="row">
  <div class="col-lg-8 col-md-12 col-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h4>Statistics</h4>
        <div class="card-header-action">
          <div class="btn-group">
            <a href="#" class="btn btn-primary">Week</a>
            <a href="#" class="btn">Month</a>
          </div>
        </div>
      </div>
      <div class="card-body"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
        <canvas id="myChart" height="608" style="display: block; width: 1003px; height: 608px;" width="1003" class="chartjs-render-monitor"></canvas>
        <div class="statistic-details mt-sm-4">
          <div class="statistic-details-item">
            <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> <span id="today-increment">7%</span></span>
            <div class="detail-value" id="today-weight">0</div>
            <div class="detail-name">Berat Hari Ini</div>
          </div>
          <div class="statistic-details-item">
            <span class="text-muted"><span class="text-danger"><i class="fas fa-caret-down"></i></span> 23%</span>
            <div class="detail-value">$2,902</div>
            <div class="detail-name">This Week's Sales</div>
          </div>
          <div class="statistic-details-item">
            <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span>9%</span>
            <div class="detail-value">$12,821</div>
            <div class="detail-name">This Month's Sales</div>
          </div>
          <div class="statistic-details-item">
            <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 19%</span>
            <div class="detail-value">$92,142</div>
            <div class="detail-name">This Year's Sales</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-12 col-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h4>Sampah Terbanyak</h4>
      </div>
      <div class="card-body">             
        
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
    var arrLabel = [];
    var arrWeight = [];
    $.ajax({
        url: '/site/get-chart-weekly/',
        success: function(data){
          data.data.forEach(function(el){
            arrLabel.push(el.weight);
          })
        }
    });
    $.ajax({
      url: '/site/get-chart-today-weight/',
      success: function(data){
        var today = data.data.today_weight;
        var yesterday = data.data.yesterday_weight;
        var increment = 0;
        if (yesterday != 0) {
          increment = ((today - yesterday) / yesterday) * 100;
        }
        $('#today-increment').text(`\${increment}%`);
        $('#today-weight').text(today)
        console.log(data);
      }
  });
    var statistics_chart = document.getElementById('myChart').getContext('2d');

    var myChart = new Chart(statistics_chart, {
      type: 'line',
      data: {
        labels: arrLabel,
        datasets: [{
          label: 'Statistics',
          data: arrWeight,
          borderWidth: 5,
          borderColor: '#6777ef',
          backgroundColor: 'transparent',
          pointBackgroundColor: '#fff',
          pointBorderColor: '#6777ef',
          pointRadius: 4
        }]
      },
      options: {
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            gridLines: {
              display: false,
              drawBorder: false,
            },
            ticks: {
              stepSize: 150
            }
          }],
          xAxes: [{
            gridLines: {
              color: '#fbfbfb',
              lineWidth: 2
            }
          }]
        },
      }
    });
    ",
    View::POS_READY,
    'aggregate-function'
);
?>