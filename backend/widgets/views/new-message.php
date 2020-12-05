<?php
/* @var $models \common\models\Chat[] */

$messageCount = count($models);

?>
<!-- Messages: style can be found in dropdown.less-->
<li class="dropdown messages-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-envelope-o"></i>
        <?if($models){?>
            <span style="font-size: 12px" class="label label-success"><?= $messageCount ?></span>
        <?}?>
    </a>
    <?if($models){?>
        <ul class="dropdown-menu">
            <li class="header">У вас <?= $messageCount ?> непрочитанных сообщений</li>
            <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                    <?foreach ($models as $model){?>
                        <li><!-- start message -->
                            <a href="<?= \yii\helpers\Url::to(['profile/view', 'id' => $model->profile_id]) ?>" data-pjax="0">
                                <p style="margin: 0"><i class="fa fa-clock-o"></i> <?= Yii::$app->formatter->asDatetime($model->date) ?></p>

                                <h4 style="margin: 0">
                                    <?= $model->profile->name ?>
                                </h4>
                                <p style="margin: 0; white-space: pre-wrap"><?= $model->text ?></p>
                            </a>
                        </li>
                    <?}?>
                </ul>
            </li>
        </ul>
    <?}?>
</li>

