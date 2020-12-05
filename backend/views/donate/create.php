<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Donate */

$this->title = 'Создать запись';
$this->params['breadcrumbs'][] = ['label' => 'Пожертвования', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="donate-create">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>

</div>
