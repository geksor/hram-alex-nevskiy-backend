<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $password \api\models\SignupForm */
?>
<div class="verify-code">

    <p>Поздравляем вы зарегистрировались в приложении</p>

    <p>Код подтверждения для завершения регистрации: <?= $user->confirm_code ?></p>

    <p>Ваш логин: <?= $user->username ?></p>
    <p>Ваш пароль: <?= $password ?></p>

</div>
