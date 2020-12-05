<?php

use common\models\Chat;
use common\widgets\Alert;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Profile */
/* @var $token common\models\Tokens */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['user/index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="profile-view">

    <?= Alert::widget() ?>
    <div class="row">

        <div class="col-xs-12 col-md-6 col-lg-4">
            <div class="box box-primary direct-chat direct-chat-primary">
                <div class="box-header with-border">
                    <?= Html::a('<i class="fa fa-reply" aria-hidden="true"></i>', ['user/index'], ['class' => 'btn btn-default']) ?>
                    <h3 class="box-title" style="margin-left: 5px">Чат с пользователем</h3>
                </div>
                <div class="box-body">
                    <div class="direct-chat-messages">
                        <?php foreach ($model->chats as $message) {?>
                            <?php if ($message->type === Chat::TYPE_USER) {?>
                                <div class="direct-chat-msg">
                                    <div class="direct-chat-info clearfix">
                                        <span class="direct-chat-name pull-left"><?= $model->name ?></span>
                                        <!--                                        <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>-->
                                    </div>
                                    <div class="direct-chat-text" style="margin-left: 5px;float: left">
                                        <?= $message->text ?>
                                    </div>
                                </div>
                            <?}

                            if ($message->type === Chat::TYPE_ADMIN) {?>
                                <div class="direct-chat-msg right">
                                    <div class="direct-chat-info clearfix">
                                        <span class="direct-chat-name pull-right">Администрация</span>
                                        <!--                                        <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>-->
                                    </div>
                                    <div class="direct-chat-text" style="margin-right: 5px;float: right;">
                                        <?= $message->text ?>
                                    </div>
                                </div>
                            <?}?>
                        <?}?>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="input-group">
                        <input type="text" id="message" name="text" placeholder="Введите сообщение ..." class="form-control">
                        <span class="input-group-btn">
                            <button data-input="#message" data-type="<?= Chat::TYPE_ADMIN ?>" type="button" class="btn btn-primary btn-flat sendMessage">Отправить</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-6">
            <div class="box box-primary">
                <div class="box-body">

                    <p>
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    </p>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
//                    'user_id',
                            'name',
                            'phone',
                            'email:email',
                            'last_donate',
                            'all_donate',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>

    </div>

</div>
<div class="dataBlock"></div>

<?php
$url = 'https://'.Yii::$app->request->hostName.'/api/chat';


$js = <<< JS
    $(document).ready(function() {
        if (firebase.messaging.isSupported()){
            const messaging = firebase.messaging();

            messaging.onMessage(function (payload) {
                if (payload.data && payload.data.chat === 'true' && payload.data.profile_id === "$model->id"){
                    pastMessage(JSON.parse(payload.data.message)).then(() => scrollChat());
                }
            });
        }

        
        var chatMessages = $('.direct-chat-messages');
        var userName = "$model->name";
        
        var scrollChat = function(){
            chatMessages.scrollTop(chatMessages.get(0).scrollHeight);
        };
        
        var pastMessage = function(message){
            var html;
            return new Promise((resolve, reject) => {
                if (message.type === 'received') {
                    html = '<div class="direct-chat-msg right"> ' +
                     '<div class="direct-chat-info clearfix">' +
                      '<span class="direct-chat-name pull-right">Администрация</span>' +
                       '</div>' +
                        '<div class="direct-chat-text" style="margin-right: 5px;float: right;">' +
                         message.text +
                          '</div>' +
                           '</div>';
                    chatMessages.append(html);
                } else {
                    html = '<div class="direct-chat-msg">' +
                     '<div class="direct-chat-info clearfix">' +
                      '<span class="direct-chat-name pull-left">'+ userName +'</span>' +
                       '</div>' +
                        '<div class="direct-chat-text" style="margin-left: 5px;float: left">' +
                         message.text +
                          '</div>' +
                           '</div>';
                    chatMessages.append(html);
                }
                resolve();
            })
        };
        
        scrollChat();

    
        $('.sendMessage').on('click', function(){
            var btn = $(this);
            var input = $(btn.data('input'));
            if (input.val()){
                var data = { 'text': input.val(), 'type': btn.data('type'), 'profile_id': $model->id }
                $.ajax({
                    type: "POST",
                    url: "$url",
                    headers: { 'Authorization': "Bearer $token->token" },
                    data: data,
                    success: function(data) {
                        console.log(data);
                        if (data.result === 'success'){
                          pastMessage(data.message).then(()=>{
                              input.val('');
                              btn.blur();
                              scrollChat()
                          });
                        } 
                    }
                })
            } 
        });
    })
JS;

$this->registerJs($js, $position = yii\web\View::POS_END, $key = null);
?>
