<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Stock */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Stock',
]) . $model->idstock;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daftar Stock'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idstock, 'url' => ['view', 'id' => $model->idstock]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="stock-update">
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
