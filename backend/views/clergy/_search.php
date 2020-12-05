<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ClergySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clergy-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'chin') ?>

    <?= $form->field($model, 'position') ?>

    <?= $form->field($model, 'birthday') ?>

    <?php // echo $form->field($model, 'name_day') ?>

    <?php // echo $form->field($model, 'jericho_ordination') ?>

    <?php // echo $form->field($model, 'deacon_ordination') ?>

    <?php // echo $form->field($model, 'education') ?>

    <?php // echo $form->field($model, 'service_places') ?>

    <?php // echo $form->field($model, 'rewards') ?>

    <?php // echo $form->field($model, 'photo') ?>

    <?php // echo $form->field($model, 'publish') ?>

    <?php // echo $form->field($model, 'abbot') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
