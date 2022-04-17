<?php


use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'nama',
    'nmperusahaan',
    'telppersh',
    'telpdriver',
    // 'lat',
    // 'lon',
    // 'sts',
    // 'stsjob',
    // 'foto',
    // 'userid',
    // 'pass',
    // 'tokenfb',
    // 'role',


    ['class' => 'app\widgets\grid\ActionColumn', 'template' => '{update} {delete}'],

];
/* @var $this yii\web\View */
/* @var $searchModel app\models\DriverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Daftar Pegawai');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="driver-index">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <div class="card">
        <div class="card-header">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <p>
                <?= Html::a(Yii::t('app', 'Pegawai Baru'), ['create'], ['class' => 'btn btn-success']) ?>
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