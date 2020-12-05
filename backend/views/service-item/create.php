<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceItem */

$this->title = 'Создать запись';
$this->params['breadcrumbs'][] = ['label' => 'Услуги', 'url' => ['service/index']];
$this->params['breadcrumbs'][] = ['label' => \common\models\Service::findOne($model->service_id)->title, 'url' => ['service/view', 'id' => $model->service_id]];
$this->params['breadcrumbs'][] = ['label' => 'Услуга', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-item-create">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>

</div>
