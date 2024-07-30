<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\FasyankesUser;
use kartik\date\DatePicker;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Withdraw */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="withdraw-form">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->

        <div class="row">
          <div class="col-lg-6">
            <?php
              $data = [];
              $url = \yii\helpers\Url::to(['fasyankes-user/fasyankes-list']);
              if (!$model->isNewRecord) {
                $dataList = FasyankesUser::find()->andWhere(['idfas' => $model->idfas])->all();
                $data = ArrayHelper::map($dataList, 'idfas', 'namapetugas');
              }
              
              echo $form->field($model, 'idfas')->widget(Select2::classname(), [
                'data' => $data,
                'options' => ['placeholder' => 'Search for a user ...', 'id' => 'idfas'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 1,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                    ],
                    'ajax' => [
                        'url' => $url,
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(item) { return item.text; }'),
                    'templateSelection' => new JsExpression('function (item) { return item.text; }'),
                ],
              ]);
            ?>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label for="bank-id" class="form-label">Bank Account</label>
              <select class="form-control form-select" name="Withdraw[idbank]" id="bank-id" aria-label="Choose bank id">
              
              </select>
            </div>
          </div>
          <div class="col-lg-6">
            <?= $form->field($model, 'amount')->textInput() ?>
          </div>
          <div class="col-lg-6">
            <?= $form->field($model, 'status')->dropDownList([
                  'requested' => 'Requested', 'transferred' => 'Transferred'],['prompt'=>'Select Status']);
            ?>
          </div>
          <div class="col-lg-6">
            <?= $form->field($model, 'request_date')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Enter request date'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]); ?>
            <!-- <?= $form->field($model, 'request_date')->textInput() ?> -->
          </div>
          <div class="col-lg-6">
          <?= $form->field($model, 'transfer_date')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Enter transfer date'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]); ?>
          </div>
        </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
$script = "
$('#idfas').on('select2:select', function(e){
  console.log(e.target.value);
  $.ajax({
    'url': '/fasyankes-user/bank-list',
    'data': {
      'id': e.target.value
    },
    success: function(data) {
      console.log(data)
      data.forEach((item) =>{
        $('#bank-id').append('<option value='+item.idbank+'>'+item.text+'</option>')
      });
      
    }
  });
})";
$this->registerJs(
    $script,
    View::POS_READY,
    'my-button-handler'
);
?>