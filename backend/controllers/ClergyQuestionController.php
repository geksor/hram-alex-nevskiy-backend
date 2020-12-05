<?php

namespace backend\controllers;

use Yii;
use common\models\ClergyQuestion;
use common\models\ClergyQuestionSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClergyQuestionController implements the CRUD actions for ClergyQuestion model.
 */
class ClergyQuestionController extends Controller
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
                        'allow' => true,
                        'roles' => ['admin', 'manager'],
                    ],
                    [
                        'actions' => [
                            'error',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ClergyQuestion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClergyQuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ClergyQuestion model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->view = 3;
        $model->update(false);

        return $this->render('view', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing ClergyQuestion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ClergyQuestion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClergyQuestion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClergyQuestion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
    }

    /**
     * @param $id
     * @param $success
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionSuccess($id, $success)
    {
        if (Yii::$app->request->isAjax){

            $model = $this->findModel($id);

            $model->view = (integer) $success;
            $model->done_at = time();

            if ($model->save(false)){
                return $this->redirect(['index']);
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * @param \yii\base\Action $action
     * @param mixed $result
     * @return mixed
     */
    public function afterAction($action, $result)
    {
        if ($action->id === 'index'){
            ClergyQuestion::updateAll(['view' => 1], 'view = 0');
        }
        return parent::afterAction($action, $result);
    }
}
