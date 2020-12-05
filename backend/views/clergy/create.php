<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Clergy */

$this->title = 'Создание записи';
$this->params['breadcrumbs'][] = ['label' => 'Духовенство', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clergy-create">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>

</div>
