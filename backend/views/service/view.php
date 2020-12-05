<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Service */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Услуги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="service-view">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">

            <p>
                <?= Html::a('<i class="fa fa-reply" aria-hidden="true"></i>', ['index'], ['class' => 'btn btn-default']) ?>
                <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Подтвердить действие?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a('Услуга', ['/service-item', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'title',
                    [
                        'attribute' => 'image',
                        'format' => 'raw',
                        'value' => function ($data){
                            /* @var $data \common\models\Service */
                            if ($data->getImageIsSet('image')){
                                return '<div class="row imageRow">'
                                    .'<div class="col-xs-5 col-md-3 col-lg-1">'
                                    .Html::img($data->getThumbImage('image'), ['style' => 'max-width: 100%;'])
                                    .'</div>'
                                    .'<div class="col-xs-3">'
                                    .Html::a('Изменить', ['set-image', 'id' => $data->id], ['class' => 'btn btn-warning'])
                                    .'</div>'
                                    .'</div>';
                            }
                            return Html::a('Установить', ['set-image', 'id' => $data->id], ['class' => 'btn btn-success']);
                        }
                    ],
                    'description:raw',
                    'publish:boolean',
                    'rank',
                ],
            ]) ?>

        </div>
    </div>

</div>

<?php
$css= <<< CSS

.imageRow{
    display: flex;
    align-items: center;
}

CSS;

$this->registerCss($css, ["type" => "text/css"], "serviceView" );
?>​

