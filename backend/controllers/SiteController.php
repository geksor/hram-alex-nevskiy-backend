<?php
namespace backend\controllers;

use backend\actions\SetImageFromSettings;
use backend\firebase\FirebaseNotifications;
use common\models\Gallery;
use common\models\History;
use common\models\Contact;
use common\models\Library;
use common\models\PrivatePolicy;
use common\models\Project;
use common\models\School;
use common\models\Shop;
use common\models\Sisterhood;
use phpcent\Client;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\web\ServerErrorHttpException;
use zxbodya\yii2\galleryManager\GalleryManagerAction;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'login',
                            'error',
                        ],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => [
                            'login',
                        ],
                        'allow' => false,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => [
                            'error',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'image-history' => [
                'class' => SetImageFromSettings::className(),
                'folder' => 'pages_img',
                'propImage' => 'image',
                'title' => 'Изображение истории',
                'fromModel' => new History(),
                'backLink' => 'history',
                'width' => 360,
                'height' => 230,
            ],
            'image-contact' => [
                'class' => SetImageFromSettings::className(),
                'folder' => 'pages_img',
                'propImage' => 'image',
                'title' => 'Изображение контактов',
                'fromModel' => new Contact(),
                'backLink' => 'contact',
                'width' => 360,
                'height' => 230,
            ],
            'image-library' => [
                'class' => SetImageFromSettings::className(),
                'folder' => 'pages_img',
                'propImage' => 'image',
                'title' => 'Изображение библиотеки',
                'fromModel' => new Library(),
                'backLink' => 'library',
                'width' => 360,
                'height' => 230,
            ],
            'image-shop' => [
                'class' => SetImageFromSettings::className(),
                'folder' => 'pages_img',
                'propImage' => 'image',
                'title' => 'Изображение лавки',
                'fromModel' => new Shop(),
                'backLink' => 'shop',
                'width' => 360,
                'height' => 230,
            ],
            'image-school' => [
                'class' => SetImageFromSettings::className(),
                'folder' => 'pages_img',
                'propImage' => 'image',
                'title' => 'Изображение школы',
                'fromModel' => new School(),
                'backLink' => 'school',
                'width' => 360,
                'height' => 230,
            ],
            'image-sisterhood' => [
                'class' => SetImageFromSettings::className(),
                'folder' => 'pages_img',
                'propImage' => 'image',
                'title' => 'Изображение Сестричества',
                'fromModel' => new Sisterhood(),
                'backLink' => 'sisterhood',
                'width' => 360,
                'height' => 230,
            ],
            'galleryApi' => [
                'class' => GalleryManagerAction::className(),
                // mappings between type names and model classes (should be the same as in behaviour)
                'types' => [
                    'galleries' => Gallery::className(),
                ]
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionContact()
    {
        $model = new Contact();

        if ($model->load(Yii::$app->params)) {
            if (Yii::$app->request->post()) {
                if ($model->save()){
                    Yii::$app->session->setFlash('success', 'Операция выполнена успешно');
                }else{
                    Yii::$app->session->setFlash('error', 'Что то пошло не так, попробуйте еще раз.');
                };
                return $this->redirect(['contact']);
            }
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionHistory()
    {
        $model = new History();
        $modelGallery = null;

        if ($model->load(Yii::$app->params)) {
            $modelGallery = Gallery::findOne(['id' => $model->gallery_id]);
            if (Yii::$app->request->post()) {
                if ($model->save()){
                    Yii::$app->session->setFlash('success', 'Операция выполнена успешно');
                }else{
                    Yii::$app->session->setFlash('error', 'Что то пошло не так, попробуйте еще раз.');
                };
                return $this->redirect(['history']);
            }
        }

        return $this->render('history', [
            'model' => $model,
            'modelGallery' => $modelGallery,
        ]);
    }

    /**
     * @return \yii\web\Response
     * @throws ServerErrorHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionCreateGalleryHistory()
    {
        $pageModel = new History();
        if ($pageModel->load(Yii::$app->params)){
            $model = new Gallery();
            if ($model->save()){
                $pageModel->gallery_id = $model->id;
                if ($pageModel->save()){
                    Yii::$app->session->setFlash('success', 'Операция выполнена успешно');
                } else {
                    $model->delete();
                    Yii::$app->session->setFlash('error', 'Не удалось сохранить изменения, попробуйте еще раз.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось создать галлерею, попробуйте еще раз.');
            }
        } else {
            throw new ServerErrorHttpException('Не удалось загрузить параметры. Обратитесь к системному администратору');
        }

        return $this->redirect(['history']);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionLibrary()
    {
        $model = new Library();
        $modelGallery = null;

        if ($model->load(Yii::$app->params)) {
            $modelGallery = Gallery::findOne(['id' => $model->gallery_id]);
            if (Yii::$app->request->post()) {
                if ($model->save()){
                    Yii::$app->session->setFlash('success', 'Операция выполнена успешно');
                }else{
                    Yii::$app->session->setFlash('error', 'Что то пошло не так, попробуйте еще раз.');
                };
                return $this->redirect(['library']);
            }
        }

        return $this->render('library', [
            'model' => $model,
            'modelGallery' => $modelGallery,
        ]);
    }

    /**
     * @return \yii\web\Response
     * @throws ServerErrorHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionCreateGalleryLibrary()
    {
        $pageModel = new Library();
        if ($pageModel->load(Yii::$app->params)){
            $model = new Gallery();
            if ($model->save()){
                $pageModel->gallery_id = $model->id;
                if ($pageModel->save()){
                    Yii::$app->session->setFlash('success', 'Операция выполнена успешно');
                } else {
                    $model->delete();
                    Yii::$app->session->setFlash('error', 'Не удалось сохранить изменения, попробуйте еще раз.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось создать галлерею, попробуйте еще раз.');
            }
        } else {
            throw new ServerErrorHttpException('Не удалось загрузить параметры. Обратитесь к системному администратору');
        }

        return $this->redirect(['library']);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionShop()
    {
        $model = new Shop();
        $modelGallery = null;

        if ($model->load(Yii::$app->params)) {
            $modelGallery = Gallery::findOne(['id' => $model->gallery_id]);
            if (Yii::$app->request->post()) {
                if ($model->save()){
                    Yii::$app->session->setFlash('success', 'Операция выполнена успешно');
                }else{
                    Yii::$app->session->setFlash('error', 'Что то пошло не так, попробуйте еще раз.');
                };
                return $this->redirect(['shop']);
            }
        }

        return $this->render('shop', [
            'model' => $model,
            'modelGallery' => $modelGallery,
        ]);
    }

    /**
     * @return \yii\web\Response
     * @throws ServerErrorHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionCreateGalleryShop()
    {
        $pageModel = new Shop();
        if ($pageModel->load(Yii::$app->params)){
            $model = new Gallery();
            if ($model->save()){
                $pageModel->gallery_id = $model->id;
                if ($pageModel->save()){
                    Yii::$app->session->setFlash('success', 'Операция выполнена успешно');
                } else {
                    $model->delete();
                    Yii::$app->session->setFlash('error', 'Не удалось сохранить изменения, попробуйте еще раз.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось создать галлерею, попробуйте еще раз.');
            }
        } else {
            throw new ServerErrorHttpException('Не удалось загрузить параметры. Обратитесь к системному администратору');
        }

        return $this->redirect(['shop']);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionSchool()
    {
        $model = new School();
        $modelGallery = null;

        if ($model->load(Yii::$app->params)) {
            $modelGallery = Gallery::findOne(['id' => $model->gallery_id]);
            if (Yii::$app->request->post()) {
                if ($model->save()){
                    Yii::$app->session->setFlash('success', 'Операция выполнена успешно');
                }else{
                    Yii::$app->session->setFlash('error', 'Что то пошло не так, попробуйте еще раз.');
                };
                return $this->redirect(['school']);
            }
        }

        return $this->render('school', [
            'model' => $model,
            'modelGallery' => $modelGallery,
        ]);
    }

    /**
     * @return \yii\web\Response
     * @throws ServerErrorHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionCreateGallerySchool()
    {
        $pageModel = new School();
        if ($pageModel->load(Yii::$app->params)){
            $model = new Gallery();
            if ($model->save()){
                $pageModel->gallery_id = $model->id;
                if ($pageModel->save()){
                    Yii::$app->session->setFlash('success', 'Операция выполнена успешно');
                } else {
                    $model->delete();
                    Yii::$app->session->setFlash('error', 'Не удалось сохранить изменения, попробуйте еще раз.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось создать галлерею, попробуйте еще раз.');
            }
        } else {
            throw new ServerErrorHttpException('Не удалось загрузить параметры. Обратитесь к системному администратору');
        }

        return $this->redirect(['school']);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionSisterhood()
    {
        $model = new Sisterhood();
        $modelGallery = null;

        if ($model->load(Yii::$app->params)) {
            $modelGallery = Gallery::findOne(['id' => $model->gallery_id]);
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()){
                    Yii::$app->session->setFlash('success', 'Операция выполнена успешно');
                }else{
                    Yii::$app->session->setFlash('error', 'Что то пошло не так, попробуйте еще раз.');
                };
                return $this->redirect(['sisterhood']);
            }
        }

        return $this->render('sisterhood', [
            'model' => $model,
            'modelGallery' => $modelGallery,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionPrivatePolicy()
    {
        $model = new PrivatePolicy();

        if ($model->load(Yii::$app->params)) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()){
                    Yii::$app->session->setFlash('success', 'Операция выполнена успешно');
                }else{
                    Yii::$app->session->setFlash('error', 'Что то пошло не так, попробуйте еще раз.');
                };
                return $this->redirect(['private-policy']);
            }
        }

        return $this->render('private-policy', [
            'model' => $model,
        ]);
    }

    /**
     * @return \yii\web\Response
     * @throws ServerErrorHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionCreateGallerySisterhood()
    {
        $pageModel = new Sisterhood();
        if ($pageModel->load(Yii::$app->params)){
            $model = new Gallery();
            if ($model->save()){
                $pageModel->gallery_id = $model->id;
                if ($pageModel->save()){
                    Yii::$app->session->setFlash('success', 'Операция выполнена успешно');
                } else {
                    $model->delete();
                    Yii::$app->session->setFlash('error', 'Не удалось сохранить изменения, попробуйте еще раз.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось создать галлерею, попробуйте еще раз.');
            }
        } else {
            throw new ServerErrorHttpException('Не удалось загрузить параметры. Обратитесь к системному администратору');
        }

        return $this->redirect(['sisterhood']);
    }

    /**
     * Login action.
     *
     * @return string
     * @throws \yii\base\Exception
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
