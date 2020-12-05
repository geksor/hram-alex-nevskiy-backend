<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<section class="content">

    <div class="error-page">
        <h2 class="headline text-info"><i class="fa fa-warning text-yellow"></i></h2>

        <div class="error-content">
            <h3><?= $name ?></h3>

            <p>
                <?= nl2br(Html::encode($message)) ?>
            </p>

            <p>
                Вышеуказанная ошибка произошла, когда веб-сервер обрабатывал ваш запрос. Пожалуйста, свяжитесь с нами,
                если считаете, что это ошибка сервера. Спасибо. Тем временем вы можете  <a href='<?= Yii::$app->homeUrl ?>'>вернуться на панель инструментов</a>
                или попробовать воспользоваться формой поиска.
            </p>

        </div>
    </div>

</section>
