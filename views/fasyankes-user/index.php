<?php


use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    // 'alamat',
    // 'fax',
    // 'owner',
    // 'namapetugas',
    // 'jabatanpetugas',
    // 'npwp',
    // 'email:email',
    // 'website',
    // 'bidangusaha',
    // 'notaris',
    // 'alamatnotaris',
    // 'nomoraktenotaris',
    // 'tglaktenotaris',
    // 'nosiup',
    // 'pkp',
    // 'nodomisilipersh',
    // 'notandapersh',
    'userid',
    // 'pass',
    'namafas',
    // 'ttdmanagement',
    // 'ttdclient',
    // 'lat',
    // 'lon',
    // 'tokenfb',
    // 'role',
    // 'tglinput',
    'nip',
    'nik',
    'telp',
    'email:email',
    
    // 'saldo',


    ['class' => 'app\widgets\grid\ActionColumn', 'template' => '{update} {delete}'],

];
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
                <?= Html::a(Yii::t('app', 'New User'), ['create'], ['class' => 'btn btn-primary']) ?>
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