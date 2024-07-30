<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrderRevision */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Order Revision',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daftar Order Revision'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="order-revision-update">
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
