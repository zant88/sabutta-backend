<?php


use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;

// $gridColumns = [
//     ['class' => 'yii\grid\SerialColumn'],
//     'userid',
//     'owner',
//     'namafas',
//     'nip',
//     'nik',
//     'telp',
//     'email:email',
//     ['class' => 'app\widgets\grid\ActionColumn', 'template' => '{update} {delete}'],
// ];


if (Yii::$app->user->can("admin")) {
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        'userid',
        'owner',
        'namafas',
        'nip',
        'nik',
        'telp',
        'email:email',
        ['class' => 'app\widgets\grid\ActionColumn', 'template' => '{update} {delete}'],
    ];
}else {
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        'userid',
        'namafas',
        'nip',
        'nik',
        'telp',
        'email:email',
        ['class' => 'app\widgets\grid\ActionColumn', 'template' => '{update} {delete}'],
    ];
}
/* @var $this yii\web\View */
/* @var $searchModel app\models\FasyankesUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Daftar Pengguna');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fasyankes-user-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <div class="card">
        <div class="card-header">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <p>
                <?= Html::a(Yii::t('app', 'Reset Password'), ['reset-password'], ['class' => 'btn btn-success']) ?>
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