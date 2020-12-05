<?php

use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use backend\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SocNetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Соцсети';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="soc-net-index">

    <?= \common\widgets\Alert::widget() ?>
    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('Создать запись', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    ['attribute' => 'id', 'headerOptions' => ['width' => 90]],
                    'title',
                    'pre_link',
                    [
                        'attribute' => 'image_svg',
                        'filter' => false,
                        'format' => 'raw',
                        'value' => function ($data){
                            /* @var $data \common\models\SocNet */
                            return "<div class='catImg' style=\"max-width: 30px; height: 30px; margin: 0 auto;\"> $data->image_svg </div>";
                        },
                        'headerOptions' => ['width' => 60]
                    ],
                    'description:ntext',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
<?php
$css= <<< CSS

.catImg>svg{
    max-width: 100%;
    max-height: 100%;
}

CSS;

$this->registerCss($css, ["type" => "text/css"], "SocNetIndex" );
?>​

