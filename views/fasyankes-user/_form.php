<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use  yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\FasyankesUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fasyankes-user-form">

    <?php $form = ActiveForm::begin(['id'=>'form-user']); ?>
        <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->
        <?php 
            // echo '<pre>';
            // print_r($model->idfas);
            // die;
        ?>
        <div class="row">
            <div class="col-lg-6">
                <?= $form->field($model, 'idfas')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'userid')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'namafas')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'nip')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'nik')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'telp')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        <a class="btn btn-secondary" href="/fasyankes-user/update-saldo?id=<?= $model->idfas ?>">Update Saldo</a>
        <!-- <a href="javascript:void(0)" id="btn-submit" class="btn btn-primary">Save and New</a> -->
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
$script = "
$('#btn-submit').on('click', function() { 
    var input = $('<input>')
               .attr('type', 'hidden')
               .attr('name', 'type').val('is_add_new');
    $('#form-user').append(input);
    $('#form-user').submit();
});";
$this->registerJs(
    $script,
    View::POS_READY,
    'my-button-handler'
);
?>
