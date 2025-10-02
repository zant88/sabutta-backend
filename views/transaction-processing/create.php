<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TransactionProcessing */

$this->title = Yii::t('app', 'Transaction Processing Baru');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daftar Transaction Processing'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-processing-create">
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
