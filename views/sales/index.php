<?php


use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;
use app\widgets\grid\ActionColumn;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        'format' => 'raw',
        'label' => 'Code',
        'value' => function ($model) {
            return "<a href='/sales/view/?id=$model->id'>$model->code</a>";
        }
    ],
    [
        'label' => 'Vendor',
        'value' => function ($model) {
            return $model->vendor->name;
        }
    ],
    'sales_date',
    'total',
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
            // 'surat-jalan' => function ($url) {
            //     return "<a class='btn btn-sm btn-primary btn-round' href='$url' title='Print Surat Jalan' 
            //     aria-label='Print Surat Jalan' data-pjax='0'><i class='fa fa-print' aria-hidden=''></i></a>";
            // },
            // 'print-invoice' => function ($url) {
            //     return "<a class='btn btn-sm btn-primary btn-round' href='$url' title='Print Invoice' 
            //     aria-label='Print Invoice' data-pjax='0'><i class='fa fa-file-import' aria-hidden=''></i></a>";
            // },
        ],
    ],
    // ['class' => ActionColumn::className(),'template'=>'{delete} {view}' ] 

];
/* @var $this yii\web\View */
/* @var $searchModel app\models\SalesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Daftar Sales');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-index">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <div class="card">
        <div class="card-header">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <p>
                <?= Html::a(Yii::t('app', 'Sales Baru'), ['create'], ['class' => 'btn btn-success']) ?>

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