<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SocNet */

$this->title = 'Создать запись';
$this->params['breadcrumbs'][] = ['label' => 'Соцсети', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="soc-net-create">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>

</div>
