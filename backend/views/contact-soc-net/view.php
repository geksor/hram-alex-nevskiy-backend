<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ContactSocNet */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Соцсети', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="contact-soc-net-view">

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
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'soc_net_id',
                        'format' => 'raw',
                        'value' => function ($data){
                            /* @var $data \common\models\ContactSocNet */
                            return Html::a($data->socNet->title, ['price/view', 'id' => $data->soc_net_id]);
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
