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

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        'label' => 'User',
        'value' => function ($model) {
            $order = Order::findOne($model->idorder);
            if ($order) {
                if ($order->idfasyankes != null) {
                    $user = FasyankesUser::findOne($order->idfasyankes);
                    return $user->namafas;
                }else {
                    return '-';
                }
            }else {
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
            }else {
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
                    }else {
                        $ret = strtoupper($order->lokasipenjemputan);
                    }
                }else {
                    $ret = '-';
                }
            }else {
                return '-';
            }
            
            
            return $ret;
        }
    ],
    [
        'label' => 'Tanggal',
        'value' => function ($model) {
            $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tgl);
            $newDateString = $myDateTime->format('d/m/Y');

            return $newDateString;
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


    //  ['class' => 'app\widgets\grid\ActionColumn'],

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
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
            ]); ?>
        </div>
        <?php Pjax::end(); ?>
    </div>
    
</div>