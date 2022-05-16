<div class="container-letter" style="width: 1000px; padding: 30px">
  <div class="header-container" style="display: flex; justify-content: space-between; margin-bottom: 30px">
    <div class="title-part">
      <h3 style="font-weight: bold; margin-bottom: 0;">SURAT JALAN</h3>
      <p style="margin-bottom: 0">No. <b><?= $model->surat_jalan_code ?></b></p>
    </div>
    <div class="description-part">
      <p style="margin-bottom: 0;" class="date"><?= $model->place ?>, <?= Yii::$app->formatter->asDate($model->generated_date_surat_jalan, 'php:j F Y') ?></p>
      <p style="margin-bottom: 0; font-weight: bold" class="vendor-name"><?= $model->vendor->name ?></p>
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