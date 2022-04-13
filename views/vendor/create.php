<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Vendor */

$this->title = Yii::t('app', 'Vendor Baru');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daftar Vendor'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vendor-create">
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
