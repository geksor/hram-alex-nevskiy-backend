<?php

use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use backend\widgets\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\BlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Видеоблог';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-index">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    ['attribute' => 'id', 'headerOptions' => ['width' => 90]],
                    'title',
                    [
                        'attribute' => 'video_link',
                        'headerOptions' => ['width' => 200],
                        'format' => 'raw',
                        'value' => function ($data){
                            /* @var $data \common\models\Blog */
                            return '<div class="videoWrap"><iframe width="1280" height="720" src="https://www.youtube.com/embed/'
                                .$data->video_link.
                                '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
                        }
                    ],
                    'publish_at:date',
                    'created_at:date',
                    [
                        'attribute' => 'publish',
                        'filter'=>[0=>"Не опубликованные",1=>"Опубликованные"],
                        'filterInputOptions' => ['prompt' => 'Все', 'class' => 'form-control form-control-sm'],
                        'headerOptions' => ['width' => 100],
                        'format' => 'raw',
                        'value' => function ($data){
                            /* @var $data \common\models\Blog */
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
                                    'switchChange.bootstrapSwitch' => 'function() {
                                                                            $.ajax({
                                                                            type: "GET",
                                                                            url: "/admin/blog/publish",
                                                                            data: "id="+ $(this).data("id") + "&publish=" + Number($(this).prop("checked")),
                                                                        }) }'
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
<?php
$css= <<< CSS

.videoWrap{
    max-width: 300px;
    position: relative;
    padding-top: 56%;
}
.videoWrap>*{
    max-width: 100%;
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    left: 0;
}

CSS;

$this->registerCss($css, ["type" => "text/css"], "BlogIndex" );
?>​
