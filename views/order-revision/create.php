<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\OrderRevision */

$this->title = Yii::t('app', 'Koreksi penerimaan sampah');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Koreksi penerimaan'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-revision-create" id="app">
<?php $form = ActiveForm::begin(['id' => 'order-revision']); ?>
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'form' => $form
            ]) ?>
        </div>
      </div>
      <div class="card">
        <div class="card-header">
          <h4>Item Sampah</h4>
        </div>
        <div class="card-body">
          <form>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nama Sampah</label>
                  <select class="form-control" id="waste-selection" placeholder="Silahkan pilih nama sampah">
                    <!-- <option :value="item.idsampah" v-for="item in waste_list">{{ item.nama }}</option> -->
                  </select>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Jumlah Dikurangi (Kg)</label>
                  <input type="number" id="amount-weight" class="form-control">
                </div>
              </div>
            </div>
            <a href="javascript:void()" id="btn-add-revision" class="btn btn-primary">Tambah</a>
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
          </form>
          <table class="table mt-4">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Sampah</th>
                <th scope="col">Berat</th>
              </tr>
            </thead>
            <tbody id="detail-addition">
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <h5>Detail</h5>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Sampah</th>
            <th scope="col">Berat</th>
            <th scope="col">Harga</th>
          </tr>
        </thead>
        <tbody id="detail">
        </tbody>
      </table>
    </div>
  </div>
<?php ActiveForm::end(); ?>
</div>

<?php 
$this->registerCss("
  #autocomplete {
    max-width: 400px;
    margin: 0 auto;
  }

  .autocomplete-result {
    border-top: 1px solid #eee;
    padding: 16px;
    background: transparent;
  }

  .group {
    padding: 16px;
    text-transform: uppercase;
    font-size: 14px;
    background: rgba(0, 0, 0, 0.06);
  }

  .wiki-title {
    font-size: 20px;
    margin-bottom: 8px;
  }

  .wiki-snippet {
    font-size: 14px;
    color: rgba(0, 0, 0, 0.54);
  }
");
?>
<?php 
$this->registerJsFile(
  'https://unpkg.com/vue@2',
  ['depends' => [\yii\web\JqueryAsset::class]]
);
$this->registerJsFile(
  '@web/js/views/order-revision.js',
  ['depends' => [\yii\web\JqueryAsset::class]]
);
$this->registerJsFile(
  '//cdn.jsdelivr.net/npm/sweetalert2@11',
  ['depends' => [\yii\web\JqueryAsset::class]]
);
$this->registerJsFile(
  '//cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js',
  ['depends' => [\yii\web\JqueryAsset::class]]
);
?>