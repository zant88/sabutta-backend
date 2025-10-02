<?php


use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;

$gridColumns=[['class' => 'yii\grid\SerialColumn'], 
            'user_id',
            'start_date',
            'end_date',
            'banksampah_id',


 ['class' => 'app\widgets\grid\ActionColumn'],

];
/* @var $this yii\web\View */
/* @var $searchModel app\models\TransactionProcessingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Daftar Transaction Processing');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-processing-index">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="card">
    <div class="card-header">
        <h4><?= Html::encode($this->title) ?></h4>
    </div>  
    <div class="card-body">
    <p> 
        <?=  Html::a(Yii::t('app', 'Transaction Processing Baru'), ['create'], ['class' => 'btn btn-success']) ?>
   
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
