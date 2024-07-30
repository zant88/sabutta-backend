<?php


use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;

$gridColumns=[['class' => 'yii\grid\SerialColumn'], 
            'code',
            'order_id',
            'description:ntext',
            'revision_date',


    ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {delete}'],

];
/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderRevisionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Daftar Koreksi Penerimaan Sampah');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-revision-index">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
        <div class="card">
          <div class="card-header">
              <h4><?= Html::encode($this->title) ?></h4>
          </div>  
          <div class="card-body">
          <p> 
              <?=  Html::a(Yii::t('app', 'Order Revision Baru'), ['create'], ['class' => 'btn btn-success']) ?>
        
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
