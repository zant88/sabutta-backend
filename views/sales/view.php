<?php

use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Sales */

$this->title = $model->code;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daftar Sales'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
  ['class' => 'yii\grid\SerialColumn'],
  [
    'label' => 'Sampah',
    'value' => function ($model) {
      return $model->waste->nama;
    }
  ],
  'amount_kg',
  'total_price',
  // 'status',

];
?>
<div class="sales-view">
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group field-sales-vendor_id">
                <label class="control-label">Tanggal Penjualan</label>
                <input type="text" class="form-control" disabled value="<?= $model->sales_date ?>" />
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group field-sales-vendor_id">
                <label class="control-label">Vendor</label>
                <input type="text" class="form-control" disabled value="<?= $model->vendor->name ?>" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
          ]); ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-8">
    <?= Html::a(Yii::t('app', 'Buat/Edit Surat Jalan'), ['surat-jalan', 'id' => $model->id], ['class' => 'btn btn-success mr-2']) ?>
    <?= Html::a(Yii::t('app', 'Print Invoice'), ['print-surat-jalan', 'id' => $model->id], ['class' => 'btn btn-primary mr-2']) ?>
  </div>
</div>