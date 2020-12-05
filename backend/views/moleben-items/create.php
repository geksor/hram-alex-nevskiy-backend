<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MolebenItems */

$this->title = 'Создание записи';
$this->params['breadcrumbs'][] = ['label' => 'Кнопки для молебна', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="moleben-items-create">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>

</div>
