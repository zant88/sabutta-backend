<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FasyankesUserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fasyankes-user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'idfas') ?>

    <?= $form->field($model, 'alamat') ?>

    <?= $form->field($model, 'telp') ?>

    <?= $form->field($model, 'fax') ?>

    <?= $form->field($model, 'owner') ?>

    <?php // echo $form->field($model, 'namapetugas') ?>

    <?php // echo $form->field($model, 'jabatanpetugas') ?>

    <?php // echo $form->field($model, 'npwp') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'website') ?>

    <?php // echo $form->field($model, 'bidangusaha') ?>

    <?php // echo $form->field($model, 'notaris') ?>

    <?php // echo $form->field($model, 'alamatnotaris') ?>

    <?php // echo $form->field($model, 'nomoraktenotaris') ?>

    <?php // echo $form->field($model, 'tglaktenotaris') ?>

    <?php // echo $form->field($model, 'nosiup') ?>

    <?php // echo $form->field($model, 'pkp') ?>

    <?php // echo $form->field($model, 'nodomisilipersh') ?>

    <?php // echo $form->field($model, 'notandapersh') ?>

    <?php // echo $form->field($model, 'userid') ?>

    <?php // echo $form->field($model, 'pass') ?>

    <?php // echo $form->field($model, 'namafas') ?>

    <?php // echo $form->field($model, 'ttdmanagement') ?>

    <?php // echo $form->field($model, 'ttdclient') ?>

    <?php // echo $form->field($model, 'lat') ?>

    <?php // echo $form->field($model, 'lon') ?>

    <?php // echo $form->field($model, 'tokenfb') ?>

    <?php // echo $form->field($model, 'role') ?>

    <?php // echo $form->field($model, 'tglinput') ?>

    <?php // echo $form->field($model, 'nip') ?>

    <?php // echo $form->field($model, 'nik') ?>

    <?php // echo $form->field($model, 'saldo') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
