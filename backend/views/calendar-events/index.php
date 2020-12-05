<?php

use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use backend\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CalendarEventsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'События календаря';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-events-index">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('Создать событие', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    ['attribute' => 'id', 'headerOptions' => ['width' => 90]],
                    'title',
                    'text:boolean',
                    'start_day:date',
                    'stop_day:date',
                    [
                        'attribute' => 'color',
                        'headerOptions' => ['width' => 50],
                        'content' => function ($data) {
                            /* @var $data \common\models\CalendarEvents */
                            return "<div style='width: 30px;height: 30px;background-color: $data->color'></div>";
                        }
                    ],
                    [
                        'attribute' => 'publish',
                        'filter'=>[0=>"Не опубликованные",1=>"Опубликованные"],
                        'filterInputOptions' => ['prompt' => 'Все', 'class' => 'form-control form-control-sm'],
                        'headerOptions' => ['width' => 100],
                        'format' => 'raw',
                        'value' => function ($data) {
                            /* @var $data \common\models\CalendarEvents */
                            $urlPublish = Url::to(['publish']);

                            return SwitchInput::widget([
                                'name' => "publish_$data->id",
                                'value' => $data->publish,
                                'class' => 'col-center',
                                'pluginOptions' => [
                                    'onColor' => 'success',
                                    'offColor' => 'danger',
                                    'onText' => '<i class="glyphicon glyphicon-ok"></i>',
                                    'offText' => '<i class="glyphicon glyphicon-remove"></i>',
                                ],
                                'options' => [
                                    'data-id' => $data->id,
                                ],
                                'pluginEvents' => [
                                    'switchChange.bootstrapSwitch' => "function() {
                                                                                    $.ajax({
                                                                                    type: 'GET',
                                                                                    url: '$urlPublish',
                                                                                    data: 'id='+ $(this).data('id') + '&publish=' + Number($(this).prop('checked')),
                                                                                }) }"
                                ]
                            ]);
                        }
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
