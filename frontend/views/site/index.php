<?php

/* @var $this yii\web\View */

?>

    <div class="wrapper">
        <img src="/public/img/logo.png" alt="">
        <?php if (Yii::$app->session->hasFlash('success')) {?>
            <h1 class="text-success">Ваш пароль успешно восстановлен. Данные отправлены на ваш адрес почты.</h1>
        <?}?>
        <?php if (Yii::$app->session->hasFlash('close')) {?>
            <h1 class="text-success">Пожертвование удачно принято.</h1>
        <?}?>
        <?php if (Yii::$app->session->hasFlash('canceled')) {?>
            <h1 class="text-success">Не удальсь принять пожертвование.</h1>
        <?}?>
    </div>



