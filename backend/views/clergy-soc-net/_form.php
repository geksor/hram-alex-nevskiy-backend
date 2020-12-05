<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\ClergySocNet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clergy-soc-net-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'soc_net_id')->widget(Select2::classname(), [
        'data' => $model->socNetForList,
        'options' => ['placeholder' => 'Выбрать соцсеть ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'publish')->widget(SwitchInput::className(), []) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Редактировать', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
