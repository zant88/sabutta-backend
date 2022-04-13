<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FasyankesUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fasyankes-user-form">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->

    <?= $form->field($model, 'idfas')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alamat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'owner')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'namapetugas')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jabatanpetugas')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'npwp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bidangusaha')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'notaris')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alamatnotaris')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nomoraktenotaris')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tglaktenotaris')->textInput() ?>

    <?= $form->field($model, 'nosiup')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pkp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nodomisilipersh')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'notandapersh')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'userid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pass')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'namafas')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ttdmanagement')->textInput() ?>

    <?= $form->field($model, 'ttdclient')->textInput() ?>

    <?= $form->field($model, 'lat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tokenfb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tglinput')->textInput() ?>

    <?= $form->field($model, 'nip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nik')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'saldo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
