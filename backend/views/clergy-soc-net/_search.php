<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ClergySocNetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clergy-soc-net-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'clergy_id') ?>

    <?= $form->field($model, 'soc_net_id') ?>

    <?= $form->field($model, 'link') ?>

    <?= $form->field($model, 'publish') ?>

    <?php // echo $form->field($model, 'rank') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
