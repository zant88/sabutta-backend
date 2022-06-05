<?php


use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;
use yii\web\View;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'type',
    'description:ntext',
    'cash_in',
    'cash_out',
    // 'created_date',
    // 'user_id',


    ['class' => 'app\widgets\grid\ActionColumn'],

];
/* @var $this yii\web\View */
/* @var $searchModel app\models\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transaksi Arus Kas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-index">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <div class="card">
        <div class="card-header">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <p>
                <?= Html::a('Transaction Baru', ['create'], ['class' => 'btn btn-success']) ?>

            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
            ]); ?>
            <br />
            <div class="row">
                <div class="col-lg-8">&nbsp;</div>
                <div class="col-lg-4">
                    <div class="label">
                        <p class="mb-0">Kas Terakhir</p>
                    </div>
                    <div class="value">
                        <b><h5>Rp. <span id="sum"></span>,-</h5></b>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>

<?php 
$this->registerJs(
    "function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }",
    View::POS_READY,
    'util-function'
);
$this->registerJs(
    "$.ajax({
        url: '/transaction/sum-cash/',
        success: function(data){
            console.log(data.data);
            $('#sum').text(numberWithCommas(data.data));
        }
    });
    ",
    View::POS_READY,
    'aggregate-function'
);
?>