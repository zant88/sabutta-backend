<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BanksampahSales */

$this->title = 'Banksampah Sales Baru';
$this->params['breadcrumbs'][] = ['label' => 'Daftar Banksampah Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banksampah-sales-create">
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
