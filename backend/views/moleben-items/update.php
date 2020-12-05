<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MolebenItems */

$this->title = 'Редактирование записи: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Кнопки для молебна', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="moleben-items-update">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>

</div>
