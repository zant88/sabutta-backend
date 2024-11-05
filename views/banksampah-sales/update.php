<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BanksampahSales */

$this->title = 'Update Banksampah Sales: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Daftar Banksampah Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="banksampah-sales-update">
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
