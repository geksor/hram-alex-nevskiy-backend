<?php

use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use backend\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ClergySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Духовенство';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clergy-index">

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
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    ['attribute' => 'id', 'headerOptions' => ['width' => 90]],
                    'name',
                    'chin',
                    'position',
//                    'birthday',
                    //'name_day',
                    //'jericho_ordination',
                    //'deacon_ordination',
                    //'education:ntext',
                    //'service_places:ntext',
                    //'rewards:ntext',
                    //'photo',
                    [
                        'attribute' => 'publish',
                        'filter'=>[0=>"Не опубликованные",1=>"Опубликованные"],
                        'filterInputOptions' => ['prompt' => 'Все', 'class' => 'form-control form-control-sm'],
                        'headerOptions' => ['width' => 100],
                        'format' => 'raw',
                        'value' => function ($data) {
                            /* @var $data \common\models\ContactSocNet */
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
                    'abbot:boolean',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
