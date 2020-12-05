<?php

use mihaildev\elfinder\ElFinder;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use kartik\widgets\DatePicker;
use kartik\color\ColorInput;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model common\models\CalendarEvents */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="calendar-events-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->widget(CKEditor::className(),[
        'editorOptions' => ElFinder::ckeditorOptions(
            ['elfinder'],
            [
                'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                'inline' => false, //по умолчанию false
                'height' => 200,
                'resize_enabled' => true,
            ]),
    ]) ?>

    <?= $form->field($model, 'startDayString')->widget(DatePicker::className(), [
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'value' => '23-Feb-1982',
        'pluginOptions' => [
            'todayHighlight' => true,
            'todayBtn' => true,
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy'
        ]
    ]) ?>

    <?= $form->field($model, 'stopDayString')->widget(DatePicker::className(), [
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'value' => '23-Feb-1982',
        'pluginOptions' => [
            'todayHighlight' => true,
            'todayBtn' => true,
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy'
        ]
    ]) ?>

    <?= $form->field($model, 'color')->widget(ColorInput::classname(), [
        'options' => ['placeholder' => 'Select color ...', 'readonly' => true],

    ]) ?>

    <?= $form->field($model, 'publish')->widget(SwitchInput::className(), []) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Отменить', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
