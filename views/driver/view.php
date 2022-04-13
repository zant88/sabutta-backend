<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Driver */

$this->title = $model->iddriver;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daftar Driver'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="driver-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Ubah'), ['update', 'id' => $model->iddriver], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Hapus'), ['delete', 'id' => $model->iddriver], [
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
            'nama',
            'nmperusahaan',
            'telppersh',
            'telpdriver',
            'lat',
            'lon',
            'sts',
            'stsjob',
            'foto',
            'userid',
            'pass',
            'tokenfb',
            'role',
        ],
    ]) ?>

</div>
