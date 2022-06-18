<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FasyankesUser */

$this->title = $model->idfas;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daftar  User'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fasyankes-user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Ubah'), ['update', 'id' => $model->idfas], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Hapus'), ['delete', 'id' => $model->idfas], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Apakah Anda yakin ingin menghapus item ini??'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'alamat',
            'telp',
            'fax',
            'owner',
            'namapetugas',
            'jabatanpetugas',
            'npwp',
            'email:email',
            'website',
            'bidangusaha',
            'notaris',
            'alamatnotaris',
            'nomoraktenotaris',
            'tglaktenotaris',
            'nosiup',
            'pkp',
            'nodomisilipersh',
            'notandapersh',
            'userid',
            'pass',
            'namafas',
            'ttdmanagement',
            'ttdclient',
            'lat',
            'lon',
            'tokenfb',
            'role',
            'tglinput',
            'nip',
            'nik',
            'saldo',
        ],
    ]) ?>

</div>
