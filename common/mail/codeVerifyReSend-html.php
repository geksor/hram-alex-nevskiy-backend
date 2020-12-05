<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $user common\models\User */
?>
<div class="verify-code">

    <p>Код подтверждения для завершения регистрации: <?= $user->confirm_code ?></p>

</div>
