<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SocNet */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Соцсети', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="soc-net-view">

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
                    'pre_link',
                    [
                        'attribute' => 'image_svg',
                        'format' => 'raw',
                        'value' => function ($data){
                            /* @var $data \common\models\SocNet */
                            if ($data->image_svg){
                                return '<div class="row imageRow">'
                                    .'<div class="col-xs-12 col-md-3 col-lg-2" style="margin-bottom: 15px">'
                                    ."<div style=\"max-width: 100px\"> $data->image_svg </div>"
                                    .'</div>'
                                    .'<div class="col-xs-12 col-md-6" style="margin-bottom: 15px">'
                                    .Html::a('Изменить', ['set-image', 'id' => $data->id], ['class' => 'btn btn-warning'])
                                    .'</div>'
                                    .'</div>';
                            }
                            return Html::a('Установить', ['set-image', 'id' => $data->id], ['class' => 'btn btn-success']);
                        }
                    ],
                    'description:ntext',
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
.imageRow svg{
    max-width: 100%;
    max-height: 60px;
}

CSS;

$this->registerCss($css, ["type" => "text/css"], "socNetView" );
?>​

