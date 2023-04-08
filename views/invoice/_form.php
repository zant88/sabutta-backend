<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Tanggal invoice'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]); ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'hormat_kami_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'place')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'hormat_kami_position')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'vendor_id')->dropDownList(
                $vendorData, 
                ['prompt'=>'Select...', 'id'=>'vendor_id']);?>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="control-label">Surat Jalan</label>
                <select id="surat-jalan"  class="form-control" style="height: 100px" name="Invoice[surat_jalan][]" multiple="multiple">
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 

$script = <<<END
$('#vendor_id').on('change', function(e){
    var vendor_id = $('#vendor_id').val();
    console.log(vendor_id);
    $.ajax({
        type: 'GET',
        url: `/invoice/get-sj-by-vendor/?vendor_id=\${vendor_id}`,
        success: function(data){
            $('#surat-jalan *').remove();
            data.data.forEach(item => {
                $('#surat-jalan').append('<option value="'+item.id+'">'+item.code+'</option>');
            });
            $('#surat-jalan').select2();
        } 
    });
});

END;

$this->registerJs(
    $script,
    \yii\web\View::POS_READY,
    'change-vendor-handler'
);
$this->registerJsFile(
    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
  );

  $this->registerCssFile("https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css", [], 'css-print-theme');
?>