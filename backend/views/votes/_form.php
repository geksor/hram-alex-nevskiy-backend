<?php

use kartik\widgets\DatePicker;
use kartik\widgets\SwitchInput;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Votes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="votes-form">

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

    <?= $form->field($model, 'publish')->widget(SwitchInput::className(), []) ?>

    <?= $form->field($model, 'pubDateToForm')->widget(DatePicker::className(), [
        'name' => 'dp_3',
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'pluginOptions' => [
            'todayHighlight' => true,
            'todayBtn' => true,
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy'
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Отменить', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
