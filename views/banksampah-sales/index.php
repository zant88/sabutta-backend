<?php

use app\models\Mbanksampah;
use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;

$gridColumns = [
  ['class' => 'yii\grid\SerialColumn'],
  // 'code',
  [
    'attribute' => 'code',
    'format' => 'raw',
    'value' => function ($data) {
      return '<a href="/banksampah-sales/view?id=' . $data->id . '">' . $data->code . '</a>';
    }
  ],
  // 'from_banksampah_id',
  [
    'label' => 'Dari',
    'value' => function ($data) {
      if ($data->from_banksampah_id != null) {
        $bankSampah = Mbanksampah::findOne($data->from_banksampah_id);
        return $bankSampah->full_name;
      }
    }
  ],
  // 'to_banksampah_id',
  'transaction_date',
  [
    'attribute' => 'total',
    'value' => function ($data) {
      return number_format($data->total);
    }
  ],
  // 'created_at',
  // 'created_by',
  // 'status',
  // 'pickup_at',
  // 'vehicle_type',
  // 'nopol',
  // 'pickup_name',
  // 'pickup_description:ntext',


  ['class' => 'app\widgets\grid\ActionColumn'],

];
/* @var $this yii\web\View */
/* @var $searchModel app\models\BanksampahSalesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Banksampah Sales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banksampah-sales-index">
  <div class="card">
    <div class="card-header">
      <h4><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="card-body">
      <?php 
      if (!Yii::$app->user->can('admin')) {
        ?>
      <p>
        <?= Html::a('Banksampah Sales Baru', ['create'], ['class' => 'btn btn-success']) ?>
      </p>
        <?php 
      }
      ?>
      <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
      ]); ?>
    </div>
  </div>
</div>