<?
/* @var $paramsHomePage \common\models\HomePage */
/* @var $paramsContact \common\models\Contact */
?>

<div class="header header-shadow">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg navbar-light bg-white">
                    <a href="/"><img class="header__labirint-logo" src="/public/img/labirint-logo.svg"
                                     alt="Логотип Лабиринт"
                                     style="width: 100%"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <img class="header__labirint-logo-mobile" src="/public/img/labirint-logo.svg"
                             alt="Логотип Лабиринт"
                             style="width: 100%">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav m-auto">
                            <li class="nav-item">
                                <a class="nav-link header__navigation-item" href="/catalog">Услуги и цены</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link header__navigation-item" href="/projects">Наши работы</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link header__navigation-item" href="/blog">Блог</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link header__navigation-item" href="/about">О нас</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link header__navigation-item" href="/contact">Контакты</a>
                            </li>
                        </ul>
                    </div>
                    <div class="header__contacts-wrapper">
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle header__navigation-item" href="#" id="navbarDropdown"
                               role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= $paramsContact->phone_1 ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="tel:<?= $paramsContact->phone_1 ?>"><?= $paramsContact->phone_1 ?></a>
                                <a class="dropdown-item" href="tel:<?= $paramsContact->phone_2 ?>"><?= $paramsContact->phone_2 ?></a>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>

