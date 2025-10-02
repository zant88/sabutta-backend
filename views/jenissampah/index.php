<?php

use app\models\Mbanksampah;
use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use app\modules\user\models\User;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'nama',
    // 'hargaperkg',
    // [
    //     'label' => 'Harga Default',
    //     'attribute' => 'hargaperkg',
    // ],
    [
        'format' => 'raw',
        'label' => 'Harga',
        'value' => function ($model) {
            $price = 0;
            $data = json_decode($model->json);        
            $dataArray = json_decode(json_encode($data), true);
            try {
                $dataArray = $dataArray['vendors'];
            
            }catch (Exception $e) {
                $dataArray = [];
            
            }
            if (Yii::$app->user->can('admin')) {
                return $model->hargaperkg;
            }else {
                $user = User::findOne(Yii::$app->user->id); 
                foreach ($dataArray as $j => $itemSampah) {
                    $bsCode = $user->banksampah_code;
                    if (!$bsCode) {
                        $bankSampah = Mbanksampah::findOne($user->banksampah_id);
                        $bsCode = $bankSampah->banksampahid;
                    }
                    if ($itemSampah['vendorId'] == $bsCode) {
                        
                        $price = $itemSampah['hargaBeli'];
                    }
                }
                return $price;
            }
            
        }
    ],
    'desc',
    [
        'attribute' => 'status',
        'headerOptions' => ['style' => 'width:150px'],
    ],
    // 'roleuser',
    ['class' => 'app\widgets\grid\ActionColumn', 'template' => Yii::$app->user->can('admin') ? '{update} {view} {delete}' : '{update}'],
];

$gridColumnsExport = [
    ['class' => 'yii\grid\SerialColumn'],
    'nama',
    'hargaperkg',
    'desc',
    ['class' => 'app\widgets\grid\ActionColumn'],
];
/* @var $this yii\web\View */
/* @var $searchModel app\models\JenissampahSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Daftar Sampah');
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
            <p>
                <?php 
                if (Yii::$app->user->can('admin')) {
                    ?>
                <?= Html::a(Yii::t('app', 'Sampah Baru'), ['create'], ['class' => 'btn btn-success']) ?>
                    <?php
                }
                ?>
            </p>
            <p>
                <?php 
                // Renders a export dropdown menu
                echo ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumnsExport
                ]);
                ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
            ]); ?>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>