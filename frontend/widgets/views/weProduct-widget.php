<?
/* @var $models \common\models\Product[] */
?>

<?php if ($models) {?>
    <div class="main__projects">
        <div class="container-fluid main__projects-background-image">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h2 class="main__projects-title-text">
                            Проекты выполненные нашей командой
                        </h2>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($models as $model) {?>
                        <div class="col-lg-4 main__projects-item-wrapper d-flex flex-column justify-content-between">
                            <a href="<?= $model->productAlias ?>">
                                <img class="main__projects-title-image-block" src="<?= $model->getThumbImage() ?>" alt="<?= $model->title ?>"
                                     style="width: 100%">
                            </a>
                            <?php if ($model->props) {?>
                                <?php foreach ($model->props as $prop) {?>
                                    <p class="main__projects-text">
                                        <?= $prop->title ?>:
                                        <span class="main__projects-text-bold">
                                            <?= $prop->value ?>
                                        </span>
                                    </p>
                                <?}?>
                            <?}?>

                            <p class="main__projects-text">
                                Цена:
                                <span class="main__projects-cost">
                                    <?= Yii::$app->formatter->asInteger($model->price) ?> руб
                                </span>
                            </p>

                        </div>
                    <?}?>
                </div>
            </div>
        </div>
    </div>
<?}?>