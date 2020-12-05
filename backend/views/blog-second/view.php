<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\BlogSecond[] */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Вера в маленьком городе', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="BlogSecond-view">

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
                    [
                        'attribute' => 'video_link',
                        'format' => 'raw',
                        'value' => function ($data){
                            /* @var $data \common\models\BlogSecond */
                            return '<div class="videoWrap"><iframe width="1280" height="720" src="https://www.youtube.com/embed/'
                                .$data->video_link.
                                '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
                        }
                    ],

                    'publish_at:date',
                    'created_at:date',
                    'publish:boolean',
                ],
            ]) ?>

        </div>
    </div>

</div>

<?php
$css= <<< CSS

.videoWrap{
    max-width: 100%;
    position: relative;
    padding-top: 56%;
}
.videoWrap>*{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

CSS;

$this->registerCss($css, ["type" => "text/css"], "BlogSecondView" );
?>​
