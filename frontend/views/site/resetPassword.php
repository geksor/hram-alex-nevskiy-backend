<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Сброс пароля';
?>

<div class="wrapper">
    <img src="/public/img/logo.png" alt="">

    <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'confirmPassword')->passwordInput() ?>

    <?= Html::submitButton('Изменить', ['class' => 'change-button']) ?>

    <?php ActiveForm::end(); ?>

</div>
