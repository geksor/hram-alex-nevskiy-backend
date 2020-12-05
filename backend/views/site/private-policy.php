<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use mihaildev\ckeditor\CKEditor;


/* @var $this yii\web\View */
/* @var $model \common\models\PrivatePolicy */

$this->title = 'Политика конфедециальности';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="private-policy-params">

    <?= \common\widgets\Alert::widget() ?>

    <div class="box box-primary">
        <div class="box-body">

            <?php $form = ActiveForm::begin(); ?>

            <div class="row">
                <div class="col-xs-12">
                    <?= $form->field($model, 'text')->widget(CKEditor::className(),[
                        'editorOptions' => [
                            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                            'inline' => false, //по умолчанию false
                            'height' => 500,
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

</div>
