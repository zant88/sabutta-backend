<?php


use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;
use app\widgets\grid\ActionColumn;

$gridColumns=[['class' => 'yii\grid\SerialColumn'], 
            'code',
            'date',
            'hormat_kami_name',
            'place',
            // 'hormat_kami_position',
            // 'active_status',F
            // 'description:ntext',

            [
                'class' => ActionColumn::className(),
                // 'contentOptions' => ['style' => 'width: 7%'],
                // 'visible' => Yii::$app->user->isGuest ? false : true,
                'template'=>'{delete} {surat-jalan} {print-invoice}',
                'buttons' => [
                    'delete' => function ($url) {
                        return "<a class='btn btn-sm btn-danger btn-round' href='$url' title='Delete' 
                            aria-label='Delete' data-pjax='0' data-confirm='Are you sure you want to delete this item?'
                            data-method='post'><i class='fa fa-trash' aria-hidden=''></i></a>";
                    },
                ],
            ],

];
/* @var $this yii\web\View */
/* @var $searchModel app\models\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Invoice';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-index">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="card">
    <div class="card-header">
        <h4><?= Html::encode($this->title) ?></h4>
    </div>  
    <div class="card-body">
    <p> 
        <?=  Html::a('Invoice Baru', ['create'], ['class' => 'btn btn-success']) ?>
   
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
