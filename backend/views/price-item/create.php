<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PriceItem */

$this->title = 'Создать запись';
$this->params['breadcrumbs'][] = ['label' => 'Цена', 'url' => ['price/index']];
$this->params['breadcrumbs'][] = ['label' => \common\models\Price::findOne($model->price_id)->title, 'url' => ['price/view', 'id' => $model->price_id]];
$this->params['breadcrumbs'][] = ['label' => 'Цена', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="price-item-create">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>

</div>
