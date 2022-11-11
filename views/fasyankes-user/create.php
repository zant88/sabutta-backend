<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FasyankesUser */

$this->title = Yii::t('app', 'Pengguna Baru');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daftar Pengguna'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fasyankes-user-create">
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