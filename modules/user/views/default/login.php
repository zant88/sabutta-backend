<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var amnah\yii2\user\models\forms\LoginForm $model
 */

$this->title = Yii::t('user', 'Login 1');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-default-login">

  <?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'needs-validation'],
    'fieldConfig' => [
      'template' => "{label}\n<div class>{input}</div>\n<div>{error}</div>",
      'labelOptions' => ['class' => 'control-label'],
    ],

  ]); ?>

  <?= $form->field($model, 'email') ?>
  <?= $form->field($model, 'password')->passwordInput() ?>
  <?= $form->field($model, 'rememberMe', [
    
  ])->checkbox() ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('user', 'Login'), ['class' => 'btn btn-primary btn-lg btn-block']) ?>
  </div>

  <?php ActiveForm::end(); ?>

  <?php if (Yii::$app->get("authClientCollection", false)) : ?>
      <?= yii\authclient\widgets\AuthChoice::widget([
        'baseAuthUrl' => ['/user/auth/login']
      ]) ?>
    
  <?php endif; ?>
</div>