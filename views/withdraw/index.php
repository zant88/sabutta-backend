<?php


use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;

if (Yii::$app->user->can("admin")) {
    $gridColumns=[
        ['class' => 'yii\grid\SerialColumn'], 
        [
            'attribute'=> 'customer',
            'label' => Yii::t('app', 'Customer'),
            'value' => function($data) {
                return $data->idfas." - ".$data->customer->namafas;
                // return $data->job->name;
            }
        ],
        [
            'format' => 'raw',
            'attribute'=> 'bank',
            'label' => Yii::t('app', 'Bank'),
            'value' => function($data) {
                return "a.n ".($data->bank->namabank == null ? "-" : $data->bank->namabank)."<br />".
                ($data->bank->norekening == null ? "-" : $data->bank->norekening)."<br />".$data->bank->keterangan == null ? "-" : $data->bank->keterangan;
                // return $data->job->name;
            }
        ],
        [
            'format' => 'raw',
            'attribute' => 'amount',
            'label' => 'Amount (Rp)',
            'value' => function($data) {
                return "<div style='text-align: right; width: 100%'>".number_format($data->amount)."</div>";
            }
        ],
        'request_date',
        [
            'format' => 'raw',
            'attribute' => 'status',
            'value' => function($data) {
                $color = '#212121';
                if ($data->status == 'transferred') {
                    $color = '#63ed7a'; 
                }else if ($data->status == 'requested') {
                    $color = '#ffa426';
                }
                return "<div style='margin: 10px; padding: 10px; border-radius: 10px; text-transform: uppercase; 
                    text-align: center; border: 1px solid ".$color."; color: ".$color."'>".$data->status."</div>";
            }
        ],
        'banksampah_code',
        // 'status',
        // 'transfer_date',
        ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
    
    ];
}else {
    $gridColumns=[
        ['class' => 'yii\grid\SerialColumn'], 
        [
            'attribute'=> 'customer',
            'label' => Yii::t('app', 'Customer'),
            'value' => function($data) {
                return $data->idfas." - ".$data->customer->namafas;
                // return $data->job->name;
            }
        ],
        [
            'format' => 'raw',
            'attribute'=> 'bank',
            'label' => Yii::t('app', 'Bank'),
            'value' => function($data) {
                return "a.n ".($data->bank->namabank == null ? "-" : $data->bank->namabank)."<br />".
                ($data->bank->norekening == null ? "-" : $data->bank->norekening)."<br />".$data->bank->keterangan == null ? "-" : $data->bank->keterangan;
                // return $data->job->name;
            }
        ],
        [
            'format' => 'raw',
            'attribute' => 'amount',
            'label' => 'Amount (Rp)',
            'value' => function($data) {
                return "<div style='text-align: right; width: 100%'>".number_format($data->amount)."</div>";
            }
        ],
        'request_date',
        [
            'format' => 'raw',
            'attribute' => 'status',
            'value' => function($data) {
                $color = '#212121';
                if ($data->status == 'transferred') {
                    $color = '#63ed7a'; 
                }else if ($data->status == 'requested') {
                    $color = '#ffa426';
                }
                return "<div style='margin: 10px; padding: 10px; border-radius: 10px; text-transform: uppercase; 
                    text-align: center; border: 1px solid ".$color."; color: ".$color."'>".$data->status."</div>";
            }
        ],
        // 'banksampah_code',
        // 'status',
        // 'transfer_date',
        ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
    
    ];
}

/* @var $this yii\web\View */
/* @var $searchModel app\models\WithdrawSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Daftar Withdraw');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdraw-index">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="card">
    <div class="card-header">
        <h4><?= Html::encode($this->title) ?></h4>
    </div>  
    <div class="card-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,      
    ]); ?>
    </div>
</div>
    <?php Pjax::end(); ?>
</div>
