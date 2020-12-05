<?php

use kartik\widgets\Select2;
use mihaildev\elfinder\ElFinder;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\Service */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->widget(Select2::className(), [
        'hideSearch' => true,
        'language' => 'ru',
        'data' => $model::getTypeToForm(),
        'options' => ['placeholder' => 'Выберите тип требы...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>


    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(CKEditor::className(),[
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

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Отменить', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
