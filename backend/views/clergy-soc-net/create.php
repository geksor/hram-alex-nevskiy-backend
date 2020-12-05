<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ClergySocNet */

$this->title = 'Создать запись';
$this->params['breadcrumbs'][] = ['label' => 'Духовенство', 'url' => ['clergy/index']];
$this->params['breadcrumbs'][] = ['label' => \common\models\Clergy::findOne($model->clergy_id)->name, 'url' => ['clergy/view', 'id' => $model->clergy_id]];
$this->params['breadcrumbs'][] = ['label' => 'Социальные сети', 'url' => ['index', 'id' => $model->clergy_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clergy-soc-net-create">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>

</div>
