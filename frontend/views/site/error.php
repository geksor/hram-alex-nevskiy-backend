<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">
    <section id="wrapper" class="container-fluid">
        <div class="error-box">
            <div class="error-body text-center">
                <h1 class="text-success"><?= $exception->statusCode ?></h1>
                <h3><?= nl2br(Html::encode($message)) ?></h3>
<!--                <a href="/" class="btn btn-success btn-rounded m-b-40">На главную</a>-->
            </div>
        </div>
    </section>
</div>
