<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\OrdersAppSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы треб';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-app-index">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'rowOptions' => function($model, $key, $index, $grid){
                    /* @var $model \common\models\OrdersApp */
                    if(!$model->viewed){
                        return ['class' => 'newRow'];
                    }
                    return null;
                },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
//                    'user_id',
                    [
                        'attribute' => 'name',
                        'value' => function ($data){
                            /* @var $data \common\models\OrdersApp */
                            return \yii\helpers\StringHelper::truncate($data->name, 40);
                        }
                    ],

                    'service_name',
                    'service_action',
                    'icon_saint',
                    'amount',
//                    'processed:boolean',
                    'created_at:date',
                    //'viewed',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}',
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>

        </div>
    </div>
</div>
