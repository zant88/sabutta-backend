<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Vendor;

/* @var $this yii\web\View */
/* @var $model app\models\Jenissampah */

$this->title = $model->idsampah;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daftar Jenissampah'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jenissampah-view">

  <h1><?= Html::encode($this->title) ?></h1>  
  <div id="app">  
    <div class="card">
      <div class="card-header">
        <h4>Add Price (<?= $model->nama ?>)</h4>
      </div>
      <div class="card-body">
        <input type="hidden" ref="waste_id" value="<?= $model->idsampah ?>" />
        <div class="input-container-sales">
          <div class="sampah-container">
            <label class="control-label">Sampah</label>
            <?php
            $vendorList = Vendor::find()->all();
            $options = [];
            foreach ($vendorList as $item) {
              $options["$item->id"] = $item->name;
            }
            echo Html::dropDownList(
              'vendor',
              null,
              $options,
              [
                'class' => 'form-control',
                'id' => 'vendor',
                'ref' => 'vendor',
              ]
            ) ?>
          </div>
          <div class="form-group amount-container">
            <label>Harga Jual</label>
            <div class="input-group">
              <input v-model="price" type="text" class="form-control prie">
            </div>
          </div>
          <div class="form-group add-container">
            <a href="javascript:void(0)" v-on:click="add()" class="btn btn-primary">
              <i class="fas fa-check"></i> Add</a>
          </div>
        </div>
        <table class="table table-striped table-md">
          <tbody>
            <tr>
              <th>#</th>
              <th>Nama Vendor</th>
              <th>Harga Jual</th>
              <th></th>
            </tr>
            <tr v-for="(item, i) in items">
              <td>{{ i+1 }}</td>
              <td>{{ item.name }}</td>
              <td>Rp. {{ item.str_price }}</td>
              <td>
                <a v-on:click="remove(i)">
                  <i class="fas fa-trash"></i>
              </td>
              </a>
            </tr>
          </tbody>
        </table>
        <br />
        <br />
        <input type="hidden" ref="idsampah" value="<?= $model->idsampah ?>" />
        <a v-on:click="save()" class="btn btn-primary">
          <i class="fas fa-save"></i> Save</a>
      </div>
    </div>
  </div>
</div>

<?php 
$this->registerJsFile(
  'https://unpkg.com/vue@2',
  ['depends' => [\yii\web\JqueryAsset::class]]
);

$this->registerJsFile(
  '@web/js/views/waste.js',
  ['depends' => [\yii\web\JqueryAsset::class]]
);

$this->registerJsFile(
  '//cdn.jsdelivr.net/npm/sweetalert2@11',
  ['depends' => [\yii\web\JqueryAsset::class]]
);
?>