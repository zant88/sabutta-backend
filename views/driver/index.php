<?php


use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;

if (Yii::$app->user->can("admin")) {
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        'iddriver',
        'nama',
        'nmperusahaan',
        'telppersh',
        'telpdriver',
        ['class' => 'app\widgets\grid\ActionColumn', 'template' => '{update} {delete}'],
    
    ];
}else {
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        'iddriver',
        'nama',
        'telppersh',
        'telpdriver',
        ['class' => 'app\widgets\grid\ActionColumn', 'template' => '{update} {delete}'],
    
    ];
}
/* @var $this yii\web\View */
/* @var $searchModel app\models\DriverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Daftar Pegawai');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="driver-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <div class="card">
        <div class="card-header">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <p>
                <?= Html::a(Yii::t('app', 'Pegawai Baru'), ['create'], ['class' => 'btn btn-success']) ?>
                <?= Html::a(Yii::t('app', 'Reset Password'), ['reset-password'], ['class' => 'btn btn-info']) ?>
            </p>
            <?php Pjax::begin(); ?>
    
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
    
</div>