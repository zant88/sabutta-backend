<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

$this->title = Yii::t('app', 'Buat Surat Jalan');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daftar Sales'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-jalan">
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
          <div class="sales-form">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->errorSummary($model) ?>
            <div class="row">
              <div class="col-lg-6">
                <?= $form->field($model, 'generated_date_surat_jalan')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Enter generated date'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]); ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($model, 'description')->textArea() ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($model, 'place')->textInput() ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($model, 'hormat_kami_name')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($model, 'hormat_kami_position')->textInput(['maxlength' => true]) ?>
              </div>
            </div>    
            <div class="form-group">
              <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
            </div>
        </div>
      </div>
    </div>      
  </div>
</div>