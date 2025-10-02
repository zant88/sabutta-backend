<?php

use app\models\FasyankesUser;
use app\models\Jenissampah;
use app\models\Order;
use app\models\WasteType;
use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use yii\widgets\ActiveForm;

$dataColumn = [
  [
    'label' => 'Pengguna',
    'value' => function ($model) {
      $order = Order::findOne($model->idorder);
      if ($order) {
        if ($order->idfasyankes != null) {
          $user = FasyankesUser::findOne($order->idfasyankes);
          if ($user) {
            return $user->namafas;
          }else {
            return '-';
          }
        } else {
          return '-';
        }
      } else {
        return '-';
      }
    }
  ],
  [
    'label' => 'Nama Sampah',
    'value' => function ($model) {
      $waste = Jenissampah::findOne($model->idjnssampah);
      return $waste->nama;
    }
  ],
  [
    'label' => 'Tipe Sampah',
    'value' => function ($model) {
      $waste = Jenissampah::findOne($model->idjnssampah);
      if ($waste->waste_type_id != null) {
        $wasteType = WasteType::findOne($waste->waste_type_id);
        return $wasteType->name;
      } else {
        return '-';
      }
    }
  ],
  [
    'label' => 'Jenis Transaksi',
    'value' => function ($model) {
      $order = Order::findOne($model->idorder);
      $ret = '-';
      if ($order) {
        if ($order->lokasipenjemputan) {
          if (strtoupper(substr($order->lokasipenjemputan, 0, 4))  == 'TPST') {
            $ret = 'TPST';
          } else {
            $ret = strtoupper($order->lokasipenjemputan);
          }
        } else {
          $ret = '-';
        }
      } else {
        return '-';
      }


      return $ret;
    }
  ],
  [
    'label' => 'Tanggal',
    'value' => function ($model) {
      if ($model->jnsstock == 'IN') {
        if ($model->idorder != null) {
          $order = Order::findOne($model->idorder);
          $myDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $order->tanggalinput);
        }else {
          $myDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $model->created_at);
        }
        if ($myDateTime) {
          $newDateString = $myDateTime->format('d/m/Y H:i:s');
        } else {
          $newDateString = '-';
        }
        return $newDateString;
      } else {
        return '-';
      }
    }
  ],
  [
    'label' => 'Keluar / Masuk',
    'value' => function ($model) {
      return $model->jnsstock;
    }
  ],
  [
    'label' => 'Berat (Kg)',
    'value' => function ($model) {
      return $model->nilai;
    }
  ],
];
if (Yii::$app->user->can("admin")) {
  $dataColumn = [
    ...$dataColumn,
    [
      'label' => 'Bank Sampah',
      'value' => function ($model) {
        return $model->banksampah_code;
      }
    ],
  ];
}
$gridColumns = [
  ['class' => 'yii\grid\SerialColumn'],
  ...$dataColumn,
];

/* @var $this yii\web\View */
/* @var $searchModel app\models\StockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Transaksi Harian');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-index">
  <div class="card">
    <div class="card-header">
      <h4><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="card-body">
      <?php
      echo ExportMenu::widget([
        'dataProvider' => $dataProviderExport,
        'columns' => $gridColumns,
      ]); ?>
      <?php Pjax::begin(); ?>
      <div class="action-row">
        <?php echo $this->render('_search', ['model' => $searchModel, 'dataProviderExport' => $dataProviderExport, 'gridColumns' => $gridColumns]); ?>
      </div>

      <!-- <p> 
        <?= Html::a(Yii::t('app', 'Stock Baru'), ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->
    <p><b>Berat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= $weight ?> Kg</b></p>
      <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
      ]); ?>
    </div>
    <?php Pjax::end(); ?>
  </div>
</div>

<?php
$this->registerCssFile("@web/css/daterangepicker.css", [], 'css-print-theme');
$this->registerJsFile(
  '@web/js/moment.js',
  ['depends' => [\yii\web\JqueryAsset::class]]
);

$this->registerJsFile(
  '@web/js/daterangepicker.js',
  ['depends' => [\yii\web\JqueryAsset::class]]
);
?>