<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ClergySocNet */

$this->title = 'Редактирование: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Духовенство', 'url' => ['clergy/index']];
$this->params['breadcrumbs'][] = ['label' => $model->clergy->name, 'url' => ['clergy/view', 'id' => $model->clergy_id]];
$this->params['breadcrumbs'][] = ['label' => 'Социальные сети', 'url' => ['index', 'id' => $model->clergy_id]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="clergy-soc-net-update">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>

</div>
