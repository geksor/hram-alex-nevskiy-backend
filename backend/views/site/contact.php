<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;


/* @var $this yii\web\View */
/* @var $model \common\models\Contact */

$this->title = 'Контакты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-params">

    <?= \common\widgets\Alert::widget() ?>

    <div class="box box-primary">
        <div class="box-body">

            <?php $form = ActiveForm::begin(); ?>

            <h2>Шапка</h2>

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <?= $form->field($model, 'title') ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?= $form->field($model, 'image')->hiddenInput() ?>
                    <div class="row" style="display: flex; align-items: center;">
                        <? if ($model->image) {?>
                            <div class="col-xs-6">
                                <?= Html::img($model->getThumbImage('image'), ['style' => 'max-width:100%']) ?>
                            </div>
                            <div class="col-xs-6">
                                <?= Html::a('Изменить', ['image-contact'], ['class' => 'btn btn-warning']) ?>
                            </div>
                        <?}else{?>
                            <div class="col-xs-6">
                                <?= Html::a('Загрузить', ['image-contact'], ['class' => 'btn btn-success']) ?>
                            </div>
                        <?}?>
                    </div>
                </div>
            </div>


            <h2>Контент</h2>

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <?= $form->field($model, 'phone') ?>
                    <?= $form->field($model, 'phoneWithText') ?>
                    <?= $form->field($model, 'email') ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?= $form->field($model, 'index') ?>
                    <?= $form->field($model, 'address') ?>
                    <?= $form->field($model, 'timetable') ?>
                </div>
            </div>

            <h2>Прочие настройки</h2>

            <?= $form->field($model, 'chatId') ?>


            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>
