<?php

use mihaildev\elfinder\ElFinder;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use kartik\widgets\SwitchInput;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Clergy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clergy-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'chin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthdayString')->widget(DatePicker::className(), [
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'value' => '23-Feb-1982',
        'pluginOptions' => [
            'todayHighlight' => true,
            'todayBtn' => true,
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy'
        ]
    ]) ?>

    <?= $form->field($model, 'name_dayString')->widget(DatePicker::className(), [
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'value' => '23-Feb-1982',
        'pluginOptions' => [
            'todayHighlight' => true,
            'todayBtn' => true,
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy'
        ]
    ]) ?>

    <?= $form->field($model, 'jericho_ordinationString')->widget(DatePicker::className(), [
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'value' => '23-Feb-1982',
        'pluginOptions' => [
            'todayHighlight' => true,
            'todayBtn' => true,
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy'
        ]
    ]) ?>

    <?= $form->field($model, 'deacon_ordinationString')->widget(DatePicker::className(), [
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'value' => '23-Feb-1982',
        'pluginOptions' => [
            'todayHighlight' => true,
            'todayBtn' => true,
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy'
        ]
    ]) ?>

    <?= $form->field($model, 'education')->widget(CKEditor::className(),[
        'editorOptions' => ElFinder::ckeditorOptions(
            ['elfinder'],
            [
                'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                'inline' => false, //по умолчанию false
                'height' => 200,
                'resize_enabled' => true,
            ]),
    ]) ?>

    <?= $form->field($model, 'service_places')->widget(CKEditor::className(),[
        'editorOptions' => ElFinder::ckeditorOptions(
            ['elfinder'],
            [
                'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                'inline' => false, //по умолчанию false
                'height' => 200,
                'resize_enabled' => true,
            ]),
    ]) ?>

    <?= $form->field($model, 'rewards')->widget(CKEditor::className(),[
        'editorOptions' => ElFinder::ckeditorOptions(
            ['elfinder'],
            [
                'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                'inline' => false, //по умолчанию false
                'height' => 200,
                'resize_enabled' => true,
            ]),
    ]) ?>

    <?= $form->field($model, 'publish')->widget(SwitchInput::className(), []) ?>

    <?php if ($model->showAbbot) {?>
        <?= $form->field($model, 'abbot')->widget(SwitchInput::className(), []) ?>
    <?}?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Отменить', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
