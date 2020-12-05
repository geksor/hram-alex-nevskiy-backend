<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CalendarEvents */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'События календаря', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="calendar-events-view">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">

            <p>
                <?= Html::a('<i class="fa fa-reply" aria-hidden="true"></i>', ['index'], ['class' => 'btn btn-default']) ?>
                <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Подтвердить удаление?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'title',
                    'text:raw',
                    'start_day:date',
                    'stop_day:date',
                    [
                        'attribute' => 'color',
                        'headerOptions' => ['width' => 50],
                        'format' => 'raw',
                        'value' => function ($data) {
                            /* @var $data \common\models\CalendarEvents */
                            return "<div style='width: 30px;height: 20px;background-color: $data->color'></div>";
                        }
                    ],
                    'publish:boolean',
                ],
            ]) ?>
        </div>
    </div>

</div>
