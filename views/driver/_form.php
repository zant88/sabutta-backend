<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Driver */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="driver-form">
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->
        <div class="row">
            <div class="col-lg-6">
            <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'nmperusahaan')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'telpdriver')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'role')
            ->dropDownList(
                ArrayHelper::map($mrole, 'idrole', 'namarole'),           // Flat array ('id'=>'label')
                ['prompt'=>'']    // options
            ); ?>
        </div>
        <div class="col-lg-6">

        </div>
    </div>

    <!-- <?= $form->field($model, 'telppersh')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'lat')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'lon')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'sts')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'stsjob')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'foto')->textInput() ?> -->

    <!-- <?= $form->field($model, 'userid')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'pass')->passwordInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'tokenfb')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'role')->textInput(['maxlength' => true]) ?> -->

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
