<?
/* @var $firstProduct \common\models\CatalogSections */
/* @var $secondProduct \common\models\CatalogSections */
/* @var $lastProduct \common\models\CatalogSections */
?>
<? if ($firstProduct) {?>
    <div class="container-fluid background-white main__quality-block-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="main__quality-image-wrapper">
                        <a href="<?= $firstProduct->getImage('main_image') ?>" data-fancybox="firstProduct-gallery">
                            <img class="main__quality-image" src="<?= $firstProduct->getThumbImage('main_image') ?>" alt="<?= $firstProduct->title ?>"
                         style="width: 100%">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 main__quality-block-two-wrapper">
                    <div class="row main__quality-image-wrapper-one">
                        <div class="col-lg-6">
                            <div class="main__quality-image-wrapper-second">
                                <a href="<?= $firstProduct->getImage('second_image_1') ?>" data-fancybox="firstProduct-gallery">
                                    <img class="main__quality-image" src="<?= $firstProduct->getThumbImage('second_image_1') ?>" alt="<?= $firstProduct->title ?>"
                                     style="width: 100%">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="main__quality-image-wrapper-second">
                                <a href="<?= $firstProduct->getImage('second_image_2') ?>" data-fancybox="firstProduct-gallery">
                                    <img class="main__quality-image" src="<?= $firstProduct->getThumbImage('second_image_2') ?>" alt="<?= $firstProduct->title ?>"
                                         style="width: 100%">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row main__quality-image-wrapper-two">
                        <div class="col-lg-12 ">
                            <div class="main__quality-product-wrapper background-grey main__quality-block-margin-bottom">
                                <div class="main__quality-text-block-wrapper-one">
                                <h3><?= $firstProduct->title ?></h3>
                                <p><?= $firstProduct->short_desc ?></p>
                                </div>
                                <div class="main__quality-text-block-wrapper-one">
                                    <a class="productOnHomeModalButton" href="#" data-toggle="modal" data-product-name='<?= $firstProduct->title ?>' data-target="#exampleModalOrder">Заказать
                                        расчет</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?}?>
<? if ($secondProduct) {?>
    <div class="container-fluid background-grey main__quality-block-wrapper">
        <div class="container">
            <div class="row ">
                <div class="col-lg-6 main__quality-block-two-wrapper">
                    <div class="row main__quality-image-wrapper-one">
                        <div class="col-lg-6">
                            <div class="main__quality-image-wrapper-second">
                                <a href="<?= $secondProduct->getImage('second_image_1') ?>" data-fancybox="secondProduct-gallery">
                                    <img class="main__quality-image" src="<?= $secondProduct->getThumbImage('second_image_1') ?>" alt="<?= $secondProduct->title ?>"
                                 style="width: 100%">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="main__quality-image-wrapper-second">
                                <a href="<?= $secondProduct->getImage('second_image_2') ?>" data-fancybox="secondProduct-gallery">
                                    <img class="main__quality-image" src="<?= $secondProduct->getThumbImage('second_image_2') ?>" alt="<?= $secondProduct->title ?>"
                                 style="width: 100%">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row main__quality-image-wrapper-two">
                        <div class="col-lg-12 ">
                            <div class="main__quality-product-wrapper background-white main__quality-block-margin-bottom">
                                <div class="main__quality-text-block-wrapper-one">
                                <h3><?= $secondProduct->title ?></h3>
                                <p><?= $secondProduct->short_desc ?></p>
                                </div>
                                <div class="main__quality-text-block-wrapper-one button-left">
                                    <a class="productOnHomeModalButton" href="#" data-toggle="modal" data-product-name='<?= $secondProduct->title ?>' data-target="#exampleModalOrder">Заказать
                                        расчет</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="main__quality-image-wrapper">
                        <a href="<?= $secondProduct->getImage('main_image') ?>" data-fancybox="secondProduct-gallery">
                            <img class="main__quality-image" src="<?= $secondProduct->getThumbImage('main_image') ?>" alt="<?= $secondProduct->title ?>"
                         style="width: 100%">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?}?>
<? if ($lastProduct) {?>
    <div class="container-fluid background-white main__quality-block-wrapper">
        <div class="container">
            <div class="row ">
                <div class="col-lg-6">
                    <div class="main__quality-image-wrapper">
                        <a href="<?= $lastProduct->getImage('main_image') ?>" data-fancybox="lastProduct-gallery">
                            <img class="main__quality-image" src="<?= $lastProduct->getThumbImage('main_image') ?>" alt="<?= $lastProduct->title ?>"
                         style="width: 100%">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 main__quality-block-two-wrapper">
                    <div class="row main__quality-image-wrapper-one">
                        <div class="col-lg-6">
                            <div class="main__quality-image-wrapper-second">
                                <a href="<?= $lastProduct->getImage('second_image_1') ?>" data-fancybox="lastProduct-gallery">
                                    <img class="main__quality-image" src="<?= $lastProduct->getThumbImage('second_image_1') ?>" alt="<?= $lastProduct->title ?>"
                                 style="width: 100%">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="main__quality-image-wrapper-second">
                                <a href="<?= $lastProduct->getImage('second_image_2') ?>" data-fancybox="lastProduct-gallery">
                                    <img class="main__quality-image" src="<?= $lastProduct->getThumbImage('second_image_2') ?>" alt="<?= $lastProduct->title ?>"
                                 style="width: 100%">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row main__quality-image-wrapper-two">
                        <div class="col-lg-12 ">
                            <div class="main__quality-product-wrapper background-grey main__quality-block-margin-bottom">
                                <div class="main__quality-text-block-wrapper-one">
                                <h3><?= $lastProduct->title ?></h3>
                                <p><?= $lastProduct->short_desc ?></p>
                                </div>
                                <div class="main__quality-text-block-wrapper-one">
                                    <a class="productOnHomeModalButton" href="#" data-toggle="modal" data-product-name='<?= $lastProduct->title ?>' data-target="#exampleModalOrder">Заказать
                                        расчет</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?}?>


<?= \frontend\widgets\ModalSectionWidget::widget() ?>

<?

$js = <<<JS

    $('.productOnHomeModalButton').on('click', function() {
        var sectionName = $($(this).data('target')).find('#callbacksection-section_name');
        sectionName.val($(this).data('product-name'));
    });
JS;

$this->registerJs($js, $position = yii\web\View::POS_END, $key = null);
?>

