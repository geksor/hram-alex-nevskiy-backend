<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CalendarEvents */

$this->title = 'Создание события';
$this->params['breadcrumbs'][] = ['label' => 'События календаря', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-events-create">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>

</div>
