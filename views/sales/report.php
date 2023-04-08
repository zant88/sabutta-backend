<?php 
use app\models\Vendor;

$vendor = Vendor::findOne($model->vendor_id);

$this->registerCss(
  "@media print {
    body {-webkit-print-color-adjust: exact;}
  }
  @page {
    size: A4 portrait;
    margin: 10mm 10mm 10mm 10mm;
    -webkit-print-color-adjust: exact;
  }
  body {
    margin:0;
    padding:0;
  }
  table { page-break-inside:auto }
  tr  { page-break-inside:avoid; }
  td  { page-break-inside:avoid; }
  // thead { display:table-header-group; }
  // tfoot { display:table-footer-group; }
  ", [
    'media' => 'print'
  ]
);
?>
<div class="container-letter" style="width: 1000px;">
  <div class="copy" style="float: right; width: 30%; text-align: right">
    <h5 style="font-size: 12px; font-style: italic">Copy untuk <?= $item ?> </h5>
  </div>
  <div class="header-container" style="display: flex; justify-content: space-between; margin-bottom: 40px; margin-top: 30px; float: left; width: 100%">
    <div class="title-part" style="width: 50%;float: left;">
      <h3 style="font-weight: bold; margin-bottom: 0; margin-top: 0">SURAT JALAN</h3>
      <p style="margin-bottom: 0">No. <b><?= $model->surat_jalan_code ?></b></p>
      <!-- <p>&nbsp;</p> -->
    </div>
    <!-- <div class="description-part"  style="width: 300px;"> -->
    <div class="description-part" style="width: 50%;float: left;">
      <p style="margin-bottom: 0;" class="date"><?= $model->place ?>, <?= Yii::$app->formatter->asDate($model->generated_date_surat_jalan, 'php:j F Y') ?></p>
      <p style="margin-bottom: 0; font-weight: bold" class="vendor-name"><?= $model->vendor->name ?></p>
      <p style="margin-bottom: 0;" class="vendor-address"><?= $vendor->address ?></p>
    </div>
  </div>
  <div class="description-container" style="margin-bottom: 10;">
    <p><?= $model->description ?></p>
  </div>
  <div class="content" style="margin-bottom: 60px;">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama Barang</th>
          <th scope="col">Berat (Kg)</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        foreach ($model->salesDetails as $key => $item) {
          ?>
        <tr>
          <th scope="row"><?= $key + 1 ?></th>
          <td><?= $item->waste->nama ?></td>
          <td><?= $item->amount_kg ?></td>
        </tr>
          
          <?php
        }
        ?>
      </tbody>
    </table>
  </div>
  <div class="footer" style="display: flex; justify-content: space-around">
    <div class="left-signature" style="width: 70%;float: left;">
      <p>Tanda Terima,</p>
      <br />
      <br />
      <br />
      <p>.............</p>
    </div>
    <div class="spacer" style="width: 100px;"></div>
    <div class="right-signature" style="width: 30%;float: left;"> 
      <p>Hormat Kami,</p>
      <br />
      <br />
      <br />
      <p style="margin-bottom: 0; line-height: 1"><b><?= $model->hormat_kami_name ?></b></p>
      <p><?= $model->hormat_kami_position ?></p>
    </div>
  </div>
</div>