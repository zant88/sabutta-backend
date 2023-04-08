<?php 
use app\models\Vendor;
use app\models\SalesDetail;

$total = 0;
$vendor = Vendor::findOne($model->vendor_id);
?>
<div class="container-letter" style="width: 1000px; padding: 30px">
  <div class="header-container" style="display: flex; justify-content: space-between; margin-bottom: 30px">
    <div class="title-part">
      <h3 style="font-weight: bold; margin-bottom: 0;">Invoice</h3>
      <p style="margin-bottom: 0">No. <b><?= $model->code ?></b></p>
    </div>
    <div class="description-part" style="width: 300px">
      <p style="margin-bottom: 0;" class="date"><?= $model->place ?>, <?= Yii::$app->formatter->asDate($model->date, 'php:j F Y') ?></p>
      <p style="margin-bottom: 0; font-weight: bold;" class="vendor-name"><?= $vendor->name ?></p>
      <p style="margin-bottom: 0;" class="vendor-address"><?= $vendor->address ?></p>
    </div>
  </div>
  <div class="description-container">
    <p><?= $model->description ?></p>
  </div>
  <div class="content">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama Barang</th>
          <th style="text-align: center;" scope="col">Berat (Kg)</th>
          <th scope="col">Total (Rp)</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        foreach ($model->invoiceDetails as $key => $item) {
          $saleItems = SalesDetail::find()->where(['sales_id' => $item->sales->id])->all();
          ?>
          <tr>
            <td colspan="3"><b>Surat Jalan : <?= $item->sales->surat_jalan_code ?></b></td>
          </tr>
          <?php
          foreach($saleItems as $idx => $saleItem) {
            $total = $total + $saleItem->total_price
            ?>
            <tr>
              <td scope="row"><?= $idx + 1 ?></td>
              <td><?= $saleItem->waste->nama ?></td>
              <td style="text-align: center;"><?= $saleItem->amount_kg ?></td>
              <td style="text-align: right;"><?= number_format($saleItem->total_price, 0, ".") ?></td>
            </tr>
            <?php
          }
          ?>
          <?php
        }
        ?>
      </tbody>
    </table>
  </div>
  <div class="footer summary" style="display: flex; justify-content: space-between;">
    <div class="total-label" style="text-align: left">&nbsp;</div>
    <!-- <div class="spacer" style="width: 160px;"></div> -->
    <div class="total" style="font-size: 18px; margin-top: 40px; text-align: right; margin-right: 55px"><b>Total : </b> Rp. <?= number_format($total, 0, ".") ?></div>
  </div>
  <div style="display: flex; justify-content: space-around; margin-top: 100px">
    <div class="left-signature">
      <p>Tanda Terima,</p>
      <br />
      <br />
      <br />
      <p>.............</p>
    </div>
    <div class="spacer" style="width: 100px;"></div>
    <div class="right-signature">
      <p>Hormat Kami,</p>
      <br />
      <br />
      <br />
      <p style="margin-bottom: 0; line-height: 1"><b><?= $model->hormat_kami_name ?></b></p>
      <p><?= $model->hormat_kami_position ?></p>
    </div>
  </div>
</div>