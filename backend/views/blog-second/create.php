<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BlogSecond */

$this->title = 'Создание записи';
$this->params['breadcrumbs'][] = ['label' => 'Вера в маленьком городе', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="BlogSecond-create">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>

</div>
