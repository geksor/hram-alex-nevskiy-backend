<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PriceItemApi */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Цена', 'url' => ['price/index']];
$this->params['breadcrumbs'][] = ['label' => $model->price->title, 'url' => ['price/view', 'id' => $model->price_id]];
$this->params['breadcrumbs'][] = ['label' => 'Цена', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="price-item-view">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">

            <p>
                <?= Html::a('<i class="fa fa-reply" aria-hidden="true"></i>', ['index', 'id' => $model->price_id], ['class' => 'btn btn-default']) ?>
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
                    'price_id',
                    [
                        'attribute' => 'price_id',
                        'format' => 'raw',
                        'value' => function ($data){
                            /* @var $data \common\models\PriceItemApi */
                            return Html::a($data->price->title, ['price/view', 'id' => $data->price_id]);
                        }
                    ],
                    'title',
                    'publish:boolean',
                    'rank',
                ],
            ]) ?>

        </div>
    </div>

</div>
