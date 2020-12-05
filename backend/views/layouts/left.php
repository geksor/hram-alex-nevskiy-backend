<aside class="main-sidebar">

    <section class="sidebar">

        <?php if (Yii::$app->user->can('admin')) {?>
            <?= dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                    'items' => [
                        ['label' => 'Меню админпанели', 'options' => ['class' => 'header']],
                        [
                            'label' => 'Пользователи',
                            'icon' => 'phone-square',
                            'url' => ['/user'],
                            "active" => Yii::$app->controller->id === 'user' || Yii::$app->controller->id === 'profile',
                        ],
                        [
                            'label' => 'Слайдер',
                            'icon' => 'phone-square',
                            'url' => ['/slider'],
                            "active" => Yii::$app->controller->id === 'slider',
                        ],
                        [
                            'label' => 'События календаря',
                            'icon' => 'phone-square',
                            'url' => ['/calendar-events'],
                            "active" => Yii::$app->controller->id === 'calendar-events',
                        ],
                        [
                            'label' => 'Соцсети',
                            'icon' => 'phone-square',
                            'url' => ['/soc-net'],
                            "active" => Yii::$app->controller->id === 'soc-net',
                        ],
                        [
                            'label' => 'Доп-разделы',
                            'icon' => 'cogs',
                            'url' => '#',
                            'items' => [
                                ['label' => 'Политика конфедециальности', 'icon' => 'home', 'url' => ['/site/private-policy']],
                                [
                                    'label' => 'Духовенство',
                                    'icon' => 'home',
                                    'url' => ['/clergy'],
                                    "active" => Yii::$app->controller->id === 'clergy',
                                ],
                                ['label' => 'История храма', 'icon' => 'home', 'url' => ['/site/history']],
                                ['label' => 'Библиотека', 'icon' => 'product-hunt', 'url' => ['/site/library']],
                                ['label' => 'Лавка', 'icon' => 'product-hunt', 'url' => ['/site/shop']],
                                ['label' => 'Воскресная школа', 'icon' => 'product-hunt', 'url' => ['/site/school']],
                                ['label' => 'Сестричество', 'icon' => 'product-hunt', 'url' => ['/site/sisterhood']],
                                [
                                    'label' => 'Контакты',
                                    'icon' => 'handshake-o',
                                    'url' => '#',
                                    'items' => [
                                        ['label' => 'Контакты', 'icon' => 'home', 'url' => ['/site/contact']],
                                        [
                                            'label' => 'Соц-сети',
                                            'icon' => 'phone-square',
                                            'url' => ['/contact-soc-net'],
                                            "active" => Yii::$app->controller->id === 'contact-soc-net',
                                        ],

                                    ]
                                ],
                                [
                                    'label' => 'Полезнык ссылки',
                                    'icon' => 'phone-square',
                                    'url' => ['/useful-links'],
                                    "active" => Yii::$app->controller->id === 'useful-links',
                                ],
                                [
                                    'label' => 'Пожертвования',
                                    'icon' => 'phone-square',
                                    'url' => ['/donate'],
                                    "active" => Yii::$app->controller->id === 'donate',
                                ],
                                [
                                    'label' => 'Предложения и голосования',
                                    'icon' => 'phone-square',
                                    'url' => ['/votes'],
                                    "active" => Yii::$app->controller->id === 'votes',
                                ],
                            ],
                        ],
                        [
                            'label' => 'Новости, блоги',
                            'icon' => 'shopping-cart',
                            'url' => '#',
                            'items' => [
                                [
                                    'label' => 'Новости',
                                    'icon' => 'product-hunt',
                                    'url' => ['/news'],
                                    "active" => Yii::$app->controller->id === 'news',
                                ],
                                [
                                    'label' => 'Маленькие новости',
                                    'icon' => 'handshake-o',
                                    'url' => ['/blog'],
                                    "active" => Yii::$app->controller->id === 'blog',
                                ],
                                [
                                    'label' => 'Вера в маленьком городе',
                                    'icon' => 'handshake-o',
                                    'url' => ['/blog-second'],
                                    "active" => Yii::$app->controller->id === 'blog-second',
                                ],

                            ]
                        ],
                        [
                            'label' => 'Требы',
                            'icon' => 'shopping-cart',
                            'url' => '#',
                            'items' => [
                                [
                                    'label' => 'Требы',
                                    'icon' => 'product-hunt',
                                    'url' => ['/service'],
                                    "active" => Yii::$app->controller->id === 'service' || Yii::$app->controller->id === 'service-item',
                                ],
                                [
                                    'label' => 'Кнопки для молебна',
                                    'icon' => 'handshake-o',
                                    'url' => ['/moleben-items'],
                                    "active" => Yii::$app->controller->id === 'moleben-items',
                                ],
                                [
                                    'label' => 'Заказанные требы',
                                    'icon' => 'handshake-o',
                                    'url' => ['/orders-app'],
                                    "active" => Yii::$app->controller->id === 'orders-app',
                                ],
                            ]
                        ],
                    ],
                ]
            ) ?>
        <?} elseif (Yii::$app->user->can('manager')){?>
            <?= dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                    'items' => [
                        ['label' => 'Меню админпанели', 'options' => ['class' => 'header']],
                        [
                            'label' => 'Чат с пользователями',
                            'icon' => 'phone-square',
                            'url' => ['/'],
                            "active" => Yii::$app->controller->id === 'chat',
                        ],
                    ],
                ]
            ) ?>
        <?}?>

    </section>

</aside>
