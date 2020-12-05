<?php

use yii\helpers\Html;
use backend\widgets\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ClergyQuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Вопросы настоятелю';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clergy-question-index">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('Создать запись', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'rowOptions' => function($model, $key, $index, $grid){
                    /* @var $model \common\models\ClergyQuestion */
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

                    ['attribute' => 'id', 'headerOptions' => ['width' => 90]],
                    [
                        'attribute' => 'user_id',
                        'format' => 'raw',
                        'value' => function ($data){
                            /* @var $data \common\models\ClergyQuestion */
                            return Html::a($data->user->profile->name, ['users/view', 'id' => $data->user_id]);
                        }
                    ],
//                    'text:ntext',
                    'created_at:date',
                    'done_at:date',
                    [
                        'attribute' => 'view',
                        'label' => 'Состояние',
                        'filter'=>[0=>"Не обработанные",2=>"Обработанные"],
                        'filterInputOptions' => ['prompt' => 'Все', 'class' => 'form-control form-control-sm'],
                        'headerOptions' => ['width' => 170],
                        'format' => 'raw',
                        'value' => function ($data){
                            /* @var $data \common\models\ClergyQuestion */
                            if (!$data->view || $data->view === 1){
                                return Html::a('Обработать',
                                    ['success', 'id' => $data->id, 'success' => 2],
                                    ['class' => 'btn btn-success col-xs-12']);
                            }
                            return 'Обработано';
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}',
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
