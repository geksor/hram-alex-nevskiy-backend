<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use zxbodya\yii2\galleryManager\GalleryManager;


/* @var $this yii\web\View */
/* @var $model \common\models\Library */
/* @var $modelGallery \common\models\Gallery */

$this->title = 'Библиотека';
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
                                <?= Html::a('Изменить', ['image-library'], ['class' => 'btn btn-warning']) ?>
                            </div>
                        <?}else{?>
                            <div class="col-xs-6">
                                <?= Html::a('Загрузить', ['image-library'], ['class' => 'btn btn-success']) ?>
                            </div>
                        <?}?>
                    </div>
                </div>
            </div>


            <h2>Контент</h2>

            <div class="row">
                <div class="col-xs-12">
                    <?= $form->field($model, 'timetable') ?>
                </div>
                <div class="col-xs-12">
                    <?= $form->field($model, 'text')->widget(CKEditor::className(),[
                        'editorOptions' => [
                            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                            'inline' => false, //по умолчанию false
                            'height' => 200,
                            'resize_enabled' => true,
                        ],
                    ]) ?>
                </div>
            </div>


            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Галерея</h3>
        </div>
        <div class="box-body">
            <? if ($modelGallery) { ?>
                <?= GalleryManager::widget(
                    [
                        'model' => $modelGallery,
                        'behaviorName' => 'galleryBehavior',
                        'apiRoute' => 'site/galleryApi'
                    ]
                ) ?>
            <?php } else { ?>
                <?= Html::a('Создать', ['create-gallery-library'], ['class' => 'btn btn-success']) ?>
            <?}?>
        </div>
    </div>

</div>
