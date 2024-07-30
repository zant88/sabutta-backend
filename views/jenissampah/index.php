<?php


use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'nama',
    'hargaperkg',
    'desc',
    [
        'attribute' => 'status',
        'headerOptions' => ['style' => 'width:150px'],
    ],
    // 'roleuser',
    ['class' => 'app\widgets\grid\ActionColumn', 'template' => '{update} {view} {delete}'],
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
                <?= Html::a(Yii::t('app', 'Sampah Baru'), ['create'], ['class' => 'btn btn-success']) ?>

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