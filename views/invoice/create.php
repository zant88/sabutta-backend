<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Invoice */

$this->title = 'Invoice Baru';
$this->params['breadcrumbs'][] = ['label' => 'Daftar Invoice', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-8">
        <div class="invoice-create">
            <div class="card">
                <div class="card-header">
                    <h4><?= Html::encode($this->title) ?></h4>
                </div>
                <div class="card-body">
                    <?= $this->render('_form', [
                        'model' => $model,
                        'vendorData' => $vendorData
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

