<?php

use app\models\Mbanksampah;
use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;
use app\modules\user\models\User;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'nama',
    [
        'label' => 'Jumlah Stok (Kg)',
        'headerOptions' => ['style' => 'width:150px'],
        'format' => 'raw',
        'value' => function($model) {
            if (Yii::$app->user->can('admin')) {
                // $bankSampah = Mbanksampah::find()->all();
                // $strOut = '';
                // foreach ($bankSampah as $item) {
                //     $rowsIn = (new \yii\db\Query())
                //         ->select(['sum(nilai) as stockIn'])
                //         ->from('stock')
                //         ->where([
                //             'jnsstock'=>'IN', 
                //             'idjnssampah'=>$model->idsampah,
                //             'banksampah_id'=>$item->id
                //         ])
                //         ->one();
                //     $rowsOut = (new \yii\db\Query())
                //         ->select(['sum(nilai) as stockOut'])
                //         ->from('stock')
                //         ->where([
                //             'jnsstock'=>'OUT', 
                //             'idjnssampah'=>$model->idsampah,
                //             'banksampah_id'=>$item->id
                //         ])
                //         ->one();
                //     $amount = ($rowsIn['stockIn'] - $rowsOut['stockOut']);
                //     $strOut = $strOut."<p style='margin: 0'>".$item->full_name." : <b>".$amount."</b></p>";
                    
                // }
                // return $strOut;
                return '<a href="javascript:void(0)" @click="fetchData(\''.$model->idsampah.'\', \''.$model->nama.'\')" data-toggle="modal" data-target="#stockModal">Lihat Stok</a>';
            }else {
                $strOut = '';
                $user = User::findOne(Yii::$app->user->id);
                $rowsIn = (new \yii\db\Query())
                        ->select(['sum(nilai) as stockIn'])
                        ->from('stock')
                        ->where([
                            'jnsstock'=>'IN', 
                            'idjnssampah'=>$model->idsampah,
                            'banksampah_id'=>$user->banksampah_id
                        ])
                        ->one();
                    $rowsOut = (new \yii\db\Query())
                        ->select(['sum(nilai) as stockOut'])
                        ->from('stock')
                        ->where([
                            'jnsstock'=>'OUT', 
                            'idjnssampah'=>$model->idsampah,
                            'banksampah_id'=>$user->banksampah_id
                        ])
                        ->one();
                    $amount = ($rowsIn['stockIn'] - $rowsOut['stockOut']);
                    $strOut = $strOut."<p>".$amount."</p>";
                return $strOut;
            }
            
        }
    ],

    // [
    //     'label' => 'Harga (Kg)',
    //     'headerOptions' => ['style' => 'width:150px'],
    //     'value' => function($model) {
    //         return $model->hargaperkg;
    //     }
    // ],
    // 'banksampah_code',
    // 'nilai',
    [
        'attribute' => 'status',
        'headerOptions' => ['style' => 'width:150px'],
    ],
    // 'roleuser',
    // ['class' => 'app\widgets\grid\ActionColumn', 'template' => '{update} {view} {delete}'],

];
/* @var $this yii\web\View */
/* @var $searchModel app\models\JenissampahSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Kartu Stok');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jenissampah-index">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <div class="card">
        <div class="card-header">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <a href="/stock/stock-opname" class="btn btn-primary">Stock Opname</a>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
            ]); ?>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>

<?php $this->beginBlock('modal'); ?>
<div class="modal fade" id="stockModal" tabindex="-1" role="dialog" aria-labelledby="stockModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="stockModalLabel">{{ modalLabel }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-md">
          <tbody>
            <tr>
              <th>#</th>
              <th>Bank Sampah</th>
              <th>Berat (Kg)</th>
            </tr>
            <tr v-for="(item, i) in data">
              <td>{{ i+1 }}</td>
              <td>{{ item.bs_name }}</td>
              <td>{{ item.qty }}</td>
            </tr>
            <!-- <tr>
              <td>2</td>
              <td>Surya Sejahtera</td>
              <td>10</td>
            </tr> -->
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <h5>Total : {{ totalStock } Kg}</h5>
      </div>
    </div>
  </div>
</div>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('scripts') ?>
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

<script>
  const { createApp, ref } = Vue

  createApp({
    setup() {
      const data = ref([]);
      const modalLabel = ref('');
      const totalStock = ref(0)
      const fetchData = async (wt_id, waste_name) =>{
        try {
          let waste_id = wt_id;
          if (waste_id != undefined) {
            const response = await axios.get(`/stock/get-waste-bank-stock?waste_id=${waste_id}`);
            totalStock.value = 0;
            response.data.forEach(element => {
              totalStock.value = totalStock.value + element.qty;
            });
            data.value = response.data;
            console.log(waste_name);
            modalLabel.value = waste_name;
          }
        }catch (error) {
          console.log(error);
        }
      }

      return {
        data,
        fetchData,
        modalLabel,
        totalStock
      }
    }
  }).mount('#app')
</script>
<?php $this->endBlock(); ?>