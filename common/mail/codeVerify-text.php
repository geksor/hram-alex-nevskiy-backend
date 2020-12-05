<?php
/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $password \api\models\SignupForm */

?>

    Поздравляем вы зарегистрировались в приложении

    Код подтверждения для завершения регистрации: <?= $user->confirm_code ?>

    Ваш логин: <?= $user->username ?>>
    Ваш пароль: <?= $password ?>
