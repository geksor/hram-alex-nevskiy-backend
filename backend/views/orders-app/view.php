<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\OrdersApp */

$this->title = $model->service_name . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Заказы треб', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="orders-app-view">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">
            <p>
                <?= Html::a('<i class="fa fa-reply" aria-hidden="true"></i>', ['index'], ['class' => 'btn btn-default']) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'user_id',
                        'format' => 'raw',
                        'value' => function ($data){
                            /* @var $data \common\models\OrdersApp */
                            $user = $data->user;
                            if ($user !== null) {
                                return Html::a($user->profile->name, ['/profile/'.$user->profile->id]);
                            }
                            return null;
                        }
                    ],
                    'name',
                    'service_name',
                    'service_action',
                    'icon_saint',
                    'amount',
//                    'processed',
                    'created_at:date',
//                    'viewed',
                ],
            ]) ?>
        </div>
    </div>

</div>
