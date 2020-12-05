<?php

use yii\helpers\Html;
use backend\widgets\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <!--    <p>-->
        <!--        --><?//= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
        <!--    </p>-->

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    ['attribute' => 'id', 'headerOptions' => ['width' => 90]],
                    'username',
                    [
                        'label' => 'Имя',
                        'value' => function ($data){
                            /* @var $data \common\models\User */
                            return $data->profile?$data->profile->name:'';
                        }
                    ],
                    'created_at:date',
                    [
                        'format' => 'raw',
                        'value' => function ($data){
                            /* @var $data \common\models\User */
                            return $data->profile?Html::a('Профиль/чат', ['profile/view', 'id' => $data->profile->id]):'';
                        }
                    ],

                    //'auth_key',
                    //'password_hash',
                    //'password_reset_token',
                    //'email:email',
                    //'status',
                    //'updated_at',
                    //'role',

//                    [
//                        'class' => 'yii\grid\ActionColumn',
//                        'template' => '{delete}',
//                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
