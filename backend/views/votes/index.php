<?php

use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use backend\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\VotesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Предложения и голосования';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="votes-index">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('Создать голосование', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'rowOptions' => function($model, $key, $index, $grid){
                    /* @var $model \common\models\Votes */
                    if(!$model->view){
                        return ['class' => 'newRow'];
                    }
                    if ($model->view === 1){
                        return ['class' => 'noReadRow'];
                    }
                    return null;
                },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'votesCount:integer',
                    [
                        'attribute' => 'user_name',
                        'format' => 'raw',
                        'value' => function ($data){
                            /* @var $data \common\models\Votes */
                            return $data->user->profile
                                ? Html::a($data->user_name, ['profile/view', 'id' => $data->user->profile->id])
                                : $data->user_name;
                        }
                    ],
                    [
                        'attribute' => 'title',
                        'format' => 'raw',
                        'contentOptions' => [
                            'style' => 'max-width:300px; white-space: normal;'
                        ],
                        'value' => function ($data){
                            /* @var $data \common\models\Votes */
                            return \yii\helpers\StringHelper::truncate($data->title, 40);
                        }
                    ],
                    [
                        'attribute' => 'text',
                        'format' => 'raw',
                        'contentOptions' => [
                            'style' => 'max-width:300px; white-space: normal;'
                        ],
                        'value' => function ($data){
                            /* @var $data \common\models\Votes */
                            return \yii\helpers\StringHelper::truncate($data->text, 40);
                        }
                    ],
                    //'type',
                    [
                        'attribute' => 'publish',
                        'filter'=>[0=>"Не опубликованные",1=>"Опубликованные"],
                        'filterInputOptions' => ['prompt' => 'Все', 'class' => 'form-control form-control-sm'],
                        'headerOptions' => ['width' => 100],
                        'format' => 'raw',
                        'value' => function ($data) {
                            /* @var $data \common\models\Service */
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
                    'publish_at:date',
                    'created_at:date',
                    //'updated_at',
                    //'view',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
