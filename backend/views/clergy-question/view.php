<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\ClergyQuestion */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Вопросы настоятелю', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="clergy-question-view">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>

            <p>
                <?= Html::a('<i class="fa fa-reply" aria-hidden="true"></i>', ['index'], ['class' => 'btn btn-default']) ?>
                <? if ($model->viewed !== 2) {?>
                    <?= Html::a('Обработать', ['success', 'id' => $model->id, 'success' => 2], ['class' => 'btn btn-success'])?>
                <?}?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'user_id',
                        'format' => 'raw',
                        'value' => function ($data){
                            /* @var $data \common\models\ClergyQuestion */
                            return Html::a($data->user->profile->name, ['users/view', 'id' => $data->user_id]);
                        }
                    ],
                    'text:ntext',
                    'created_at:date',
                    'done_at:date',
                ],
            ]) ?>

            <?php Pjax::end(); ?>
        </div>
    </div>

</div>
