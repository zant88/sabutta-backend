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
                $bankSampah = Mbanksampah::find()->all();
                $strOut = '';
                foreach ($bankSampah as $item) {
                    $rowsIn = (new \yii\db\Query())
                        ->select(['sum(nilai) as stockIn'])
                        ->from('stock')
                        ->where([
                            'jnsstock'=>'IN', 
                            'idjnssampah'=>$model->idsampah,
                            'banksampah_id'=>$item->id
                        ])
                        ->one();
                    $rowsOut = (new \yii\db\Query())
                        ->select(['sum(nilai) as stockOut'])
                        ->from('stock')
                        ->where([
                            'jnsstock'=>'OUT', 
                            'idjnssampah'=>$model->idsampah,
                            'banksampah_id'=>$item->id
                        ])
                        ->one();
                    $amount = ($rowsIn['stockIn'] - $rowsOut['stockOut']);
                    $strOut = $strOut."<p style='margin: 0'>".$item->full_name." : <b>".$amount."</b></p>";
                    
                }
                return $strOut;
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
            <a href="javascript:void(0)" class="btn btn-primary">Jual</a>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
            ]); ?>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>