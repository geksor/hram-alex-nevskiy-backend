<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ClergySocNet */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Духовенство', 'url' => ['clergy/index']];
$this->params['breadcrumbs'][] = ['label' => $model->clergy->name, 'url' => ['clergy/view', 'id' => $model->clergy_id]];
$this->params['breadcrumbs'][] = ['label' => 'Социальные сети', 'url' => ['index', 'id' => $model->clergy_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="clergy-soc-net-view">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">

            <p>
                <?= Html::a('<i class="fa fa-reply" aria-hidden="true"></i>', ['index', 'id' => $model->clergy_id], ['class' => 'btn btn-default']) ?>
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
                    [
                        'attribute' => 'clergy_id',
                        'format' => 'raw',
                        'value' => function ($data){
                            /* @var $data \common\models\ClergySocNet */
                            return Html::a($data->clergy->name, ['clergy/view', 'id' => $data->clergy_id]);
                        }
                    ],
                    [
                        'attribute' => 'soc_net_id',
                        'format' => 'raw',
                        'value' => function ($data){
                            /* @var $data \common\models\ClergySocNet */
                            return $data->socNet->title;
                        }
                    ],
                    'link',
                    'publish:boolean',
                    'rank',
                ],
            ]) ?>

        </div>
    </div>

</div>
