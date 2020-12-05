<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Clergy */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Духовенство', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="clergy-view">

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
                <?= Html::a('Социальные сети', ['/clergy-soc-net', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    'chin',
                    'position',
                    [
                        'attribute' => 'photo',
                        'format' => 'raw',
                        'value' => function ($data){
                            /* @var $data \common\models\Clergy */
                            if ($data->getImageIsSet()){
                                return '<div class="row imageRow">'
                                    .'<div class="col-xs-12 col-md-3 col-lg-2" style="margin-bottom: 15px">'
                                    .Html::img($data->getPrevImage(), ['style' => 'max-width: 100%;'])
                                    .'</div>'
                                    .'<div class="col-xs-12 col-md-6" style="margin-bottom: 15px">'
                                    .Html::a('Изменить', ['set-photo', 'id' => $data->id], ['class' => 'btn btn-warning'])
                                    .'</div>'
                                    .'</div>';
                            }
                            return Html::a('Установить', ['set-photo', 'id' => $data->id], ['class' => 'btn btn-success']);
                        }
                    ],
                    'birthday:date',
                    'name_day:date',
                    'jericho_ordination:date',
                    'deacon_ordination:date',
                    'education:raw',
                    'service_places:raw',
                    'rewards:raw',
                    'publish:boolean',
                    'abbot:boolean',
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
    flex-wrap: wrap;
}

CSS;

$this->registerCss($css, ["type" => "text/css"], "clergyView" );
?>​

