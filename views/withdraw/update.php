<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Withdraw */

$this->title = Yii::t('app', 'Proses transfer pembayaran ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daftar Withdraw'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="withdraw-update">
  <?php $form = ActiveForm::begin(); ?>
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
        <?= $this->render('_form_update', [
          'model' => $model,
          'form' => $form
        ]) ?>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <?= \zantknight\yii\gallery\Gallery4Widget::widget([
          'ownerModel' => $model,
          'multiple' => false
      ]); ?>
    </div>
  </div>
  <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
