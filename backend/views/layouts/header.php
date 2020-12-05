<?php
use yii\helpers\Html;
use yii\web\View;

$css=<<< CSS
.main-header .sidebar-toggle:before {
    content: none;
}
td img{
    max-width: 100%;
    height: auto!important;
}
CSS;
$this->registerCss($css, ["type" => "text/css"], "callBackWidget" );
/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">L</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="fas fa-bars"></span>
            <span class="sr-only">Toggle navigation</span>
        </a>
        <?php \yii\widgets\Pjax::begin(['id' => 'new-message-widget']) ?>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                <?= \backend\widgets\NewMessageWidget::widget() ?>

                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <?= Html::a('Выход', ['site/logout'], ['data'=>['method'=>'post'] ,'class'=>'btn btn-primary btn-flat']) ?>
                </li>
            </ul>
            </div>
        <?php \yii\widgets\Pjax::end() ?>
    </nav>
</header>

<?php
$url = 'https://'.Yii::$app->request->hostName.'/api/chat';


$js = <<< JS
    $(document).ready(function() {
        if (firebase.messaging.isSupported()){
            const messagingWidget = firebase.messaging();

            messagingWidget.onMessage(function (payload) {
                if (payload.data && payload.data.chat === 'true') {
                    $.pjax.reload({container: '#new-message-widget'});
                }
            });
        }
    })
JS;

$this->registerJs($js, $position = yii\web\View::POS_END, $key = null);
?>
