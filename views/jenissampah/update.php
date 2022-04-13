<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Jenissampah */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Jenissampah',
]) . $model->idsampah;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daftar Sampah'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idsampah, 'url' => ['view', 'id' => $model->idsampah]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="jenissampah-update">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4><?= Html::encode($this->title) ?></h4>
                </div>
                <div class="card-body">
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>