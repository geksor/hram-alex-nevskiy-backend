<?
/* @var $models \common\models\Category[] */
?>

<?php if ($models) {?>
    <div class="container">
        <div class="row main__features-list-wrapper">
            <?php foreach ($models as $model) {?>
                <div class="image-wrapper-one">
                    <a href="/catalog/<?= $model->alias ?>"></a>
                    <div class="background-wrapper" style="background-image: url('<?= $model->getThumbImage('image_list') ?>')"></div>
                    <div class="image-wrapper-two">
                        <div class="svg-wrapper">
                            <?= $model->svg ?>
                        </div>
                        <div class="text-wrapper">
                            <p><?= \yii\helpers\StringHelper::truncate($model->title_main, 30) ?></p>
                        </div>
                    </div>
                </div>
            <?}?>
        </div>
    </div>
<?}?>