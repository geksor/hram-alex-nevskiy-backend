<?php

/* @var $this yii\web\View */
/* @var $model common\models\UsefulLinks */

$this->title = 'Создать запись';
$this->params['breadcrumbs'][] = ['label' => 'Полезные сслыки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="useful-links-create">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>

</div>
