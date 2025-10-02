<?php


use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'name',
    'description:ntext',

];
if (Yii::$app->user->can('admin')) {
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        'description:ntext',
        ['class' => 'app\widgets\grid\ActionColumn', 'template' => '{update} {delete}'],
    
    ];
}
/* @var $this yii\web\View */
/* @var $searchModel app\models\WasteTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Daftar Jenis Sampah');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="waste-type-index">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <div class="card">
        <div class="card-header">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <?php 
                if (Yii::$app->user->can('admin')) {
                    ?>
                <?= Html::a(Yii::t('app', 'Waste Type Baru'), ['create'], ['class' => 'btn btn-success']) ?>
                    <?php
                }
                ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
            ]); ?>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>