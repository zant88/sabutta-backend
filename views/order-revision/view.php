<?php

use app\models\Orderdetail;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\OrderRevision */

$this->title = $model->code;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daftar Order Revision'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-revision-view">
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h4>Koreksi</h4>
        </div>
        <div class="card-body">
          <?= DetailView::widget([
              'model' => $model,
              'attributes' => [
                  'code',
                  'order_id',
                  'description:ntext',
                  'revision_date',
              ],
          ]) ?>
          <br />
          <br />
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">ID Sampah</th>
                <th scope="col">Nama Sampah</th>
                <th scope="col">Transaksi (Kg)</th>
                <th scope="col">Koreksi (Kg)</th>
                <th scope="col">Berat Sekarang (Kg)</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              foreach ($order_revision as $i => $item) {
                $amountTransaction = 0;
                $orderDetail = Orderdetail::find()->where(['orderid' => $model->order_id, 'idsampah'=>$item->sampah_id])->one();
                ?>
              <tr>
                <th scope="row"><?= $i + 1?></th>
                <td><?= $item->sampah_id ?></td>
                <td><?= $item->waste->nama ?></td>
                <td><?= $orderDetail->berat ?></td>
                <td><?= $item->amount_diminished ?></td>
                <td><?= ($orderDetail->berat - $item->amount_diminished)?></td>
              </tr>  
                <?php
              } 
              ?>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  
</div>
