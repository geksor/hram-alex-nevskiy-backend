<?
/* @var $paramsHomePage \common\models\HomePage */
/* @var $paramsContact \common\models\Contact */
?>

<div class="footer">
    <div class="container-fluid footer__wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 footer__logo-wrapper">
                    <a href="/"><img src="/public/img/footer-labirint-logo.svg" alt="Логотип Лабиринт" style="width: 100%"></a>
                </div>
                <div class="col-lg-4 footer__link-wrapper">
                    <a class="footer__link" href="/">Главная</a>
                    <a class="footer__link" href="/catalog">Услуги и цены</a>
                    <a class="footer__link" href="/projects">Наши работы</a>
                </div>
                <div class="col-lg-4 footer__link-wrapper">
                    <a class="footer__link" href="/blog/">Блог</a>
                    <a class="footer__link" href="/about">О нас</a>
                    <a class="footer__link" href="/contact">Контакты</a>
                </div>
                <div class="col-lg-2 footer__social-wrapper">
                    <a class="footer__social" href="<?= $paramsContact->ok ?>">
                        <img src="/public/img/ok-logo.svg" alt="Мы в Ok.ru">
                    </a>
                    <a class="footer__social" href="<?= $paramsContact->vk ?>">
                        <img src="/public/img/vk-logo.svg" alt="Мы в Vk.ru">
                    </a>
                    <a class="footer__social" href="<?= $paramsContact->facebook ?>">
                        <img src="/public/img/fb-logo.svg" alt="Мы в Fb.ru">
                    </a>
                </div>
            </div>
            <p class="footer__copyright">Все права защищены (с) <?= date('Y') ?> <a href="http://web-elitit.ru/" target="_blank">design by ELIT-IT</a></p>
        </div>
    </div>
</div>
