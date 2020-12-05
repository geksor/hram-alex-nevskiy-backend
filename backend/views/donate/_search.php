<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DonateSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="donate-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'text') ?>

    <?= $form->field($model, 'need') ?>

    <?= $form->field($model, 'now') ?>

    <?php // echo $form->field($model, 'publish') ?>

    <?php // echo $form->field($model, 'rank') ?>

    <?php // echo $form->field($model, 'crated_at') ?>

    <?php // echo $form->field($model, 'last_donate') ?>

    <?php // echo $form->field($model, 'last_donate_date') ?>

    <?php // echo $form->field($model, 'donate_count') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
