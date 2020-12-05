<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\BlogSecond */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="BlogSecond-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'video_link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pubDateToForm')->widget(DatePicker::classname(), [
        'name' => 'dp_3',
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'value' => '23-Feb-1982',
        'pluginOptions' => [
            'todayHighlight' => true,
            'todayBtn' => true,
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy'
        ]
    ]) ?>

    <?= $form->field($model, 'publish')->widget(SwitchInput::classname(), []) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Отменить', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
