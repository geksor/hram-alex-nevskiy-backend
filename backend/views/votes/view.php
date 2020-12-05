<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Votes */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Предложения и голосования', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="votes-view">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">

            <p>
                <?= Html::a('<i class="fa fa-reply" aria-hidden="true"></i>', ['index'], ['class' => 'btn btn-default']) ?>
                <?php if (!$model->publish) {?>
                    <?= Html::a('Публикация', ['publish', 'id' => $model->id, 'publish' => 1], ['class' => 'btn btn-success']) ?>
                <?}?>
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
                    'votesCount',
                    'user_name',
                    'title',
                    'text:ntext',
                    'type',
                    'publish:boolean',
                    'publish_at:date',
                    'created_at:date',
                    'updated_at:date',
                ],
            ]) ?>
        </div>
    </div>

</div>
