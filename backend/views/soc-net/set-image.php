<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \common\models\SocNet */

$this->title = 'Выбор Изображения: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Соцсети', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Выбор изображения';
?>
<div class="soc-net-set-image">

    <div class="box box-primary">
        <div class="box-body">
            <?= Html::a('<i class="fa fa-reply" aria-hidden="true"></i>', Yii::$app->request->referrer, ['class' => 'btn btn-default']) ?>

            <?= $this->render('_form-image', [
                'model' => $model,
            ]) ?>

        </div>
    </div>

</div>
