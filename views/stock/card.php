<?php


use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;
use \yii\db\Query;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'nama',
    [
        'label' => 'Jumlah Stok (Kg)',
        'headerOptions' => ['style' => 'width:150px'],
        'value' => function($model) {
            $rowsIn = (new \yii\db\Query())
                ->select(['sum(nilai) as stockIn'])
                ->from('stock')
                ->where(['jnsstock'=>'IN', 'idjnssampah'=>$model->idsampah])
                ->one();
            $rowsOut = (new \yii\db\Query())
                ->select(['sum(nilai) as stockOut'])
                ->from('stock')
                ->where(['jnsstock'=>'OUT', 'idjnssampah'=>$model->idsampah])
                ->one();
            return ($rowsIn['stockIn'] - $rowsOut['stockOut']);
        }
    ],
    [
        'label' => 'Harga (Kg)',
        'headerOptions' => ['style' => 'width:150px'],
        'value' => function($model) {
            return $model->hargaperkg;
        }
    ],
    // 'hargaperkg',
    
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
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
            ]); ?>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>