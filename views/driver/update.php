<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Driver */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Driver',
]) . $model->iddriver;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daftar Driver'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->iddriver, 'url' => ['view', 'id' => $model->iddriver]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="driver-update">
<div class="card">
    <div class="card-header">
        <h4><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="card-body">
    <?= $this->render('_form', [
        'model' => $model,
        'mrole' => $mrole,
    ]) ?>
    </div>
</div>
    

</div>
