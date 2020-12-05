<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceItem */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Услуги', 'url' => ['service/index']];
$this->params['breadcrumbs'][] = ['label' => $model->service->title, 'url' => ['service/view', 'id' => $model->service_id]];
$this->params['breadcrumbs'][] = ['label' => 'Услуга', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="service-item-view">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">

            <p>
                <?= Html::a('<i class="fa fa-reply" aria-hidden="true"></i>', ['index', 'id' => $model->service_id], ['class' => 'btn btn-default']) ?>
                <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Подтвердить действие?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'service_id',
                        'format' => 'raw',
                        'value' => function ($data){
                            /* @var $data \common\models\ServiceItem */
                            return Html::a($data->service->title, ['service/view', 'id' => $data->service_id]);
                        }
                    ],

                    'title',
                    'description:raw',
                    'publish:boolean',
                    'rank',
                ],
            ]) ?>

        </div>
    </div>

</div>
