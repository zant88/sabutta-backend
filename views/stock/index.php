<?php

use app\models\Jenissampah;
use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;

$gridColumns=[['class' => 'yii\grid\SerialColumn'], 
            [
                'label' => 'Nama Sampah',
                'value' => function ($model) {
                    $waste = Jenissampah::findOne($model->idjnssampah);
                    return $waste->nama;
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
                'label' => 'Jenis Transaksi',
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
            // 'nilai',
            // 'jnsstock',
            // 'idorder',


//  ['class' => 'app\widgets\grid\ActionColumn'],

];
/* @var $this yii\web\View */
/* @var $searchModel app\models\StockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Transaksi Stock');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-index">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="card">
    <div class="card-header">
        <h4><?= Html::encode($this->title) ?></h4>
    </div>  
    <div class="card-body">
    <!-- <p> 
        <?=  Html::a(Yii::t('app', 'Stock Baru'), ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,      
    ]); ?>
    </div>
</div>
    <?php Pjax::end(); ?>
</div>
