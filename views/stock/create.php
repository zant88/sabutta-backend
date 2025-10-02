<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Stock */

$this->title = Yii::t('app', 'Stock Baru');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daftar Stock'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-create">
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