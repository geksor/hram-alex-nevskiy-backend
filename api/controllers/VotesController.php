<?php

namespace api\controllers;

use api\models\VotesApi;
use common\models\Votes;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\helpers\Url;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

/**
 * Site controller
 */
class VotesController extends AddBehaviorControllerAuthAll
{
	public $modelClass = VotesApi::class;

	/**
	 * {@inheritdoc}
	 */
	public function actions()
	{
		$actions = parent::actions();

		unset($actions['create'], $actions['update'], $actions['delete']);

		$actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

		return $actions;
	}

	public function prepareDataProvider(): ActiveDataProvider
	{
		return new ActiveDataProvider([
			'query' => VotesApi::find()->active()->orderVotes()
		]);
	}

	/**
	 * @return Votes
	 * @throws ServerErrorHttpException
	 */
	public function actionCreate(): Votes
	{
		$model = new Votes();
		$model->user_id = Yii::$app->user->id;

		$model->load(Yii::$app->request->bodyParams, '');

		if ($model->save()) {
			$response = Yii::$app->getResponse();
			$response->setStatusCode(201);
			$id = implode(',', array_values($model->getPrimaryKey(true)));
			$response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
		} elseif (!$model->hasErrors()) {
			throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
		}

		return $model;
	}

	/**
	 * @param $id
	 * @return array
	 * @throws MethodNotAllowedHttpException
	 * @throws NotFoundHttpException
	 * @throws StaleObjectException
	 * @throws Throwable
	 */
	public function actionVote($id): array
	{
		if (Yii::$app->request->isPost) {
			return VotesApi::linkVotes($id);
		}

		if (Yii::$app->request->isDelete) {
			return VotesApi::unlinkVotes($id);
		}

		throw new MethodNotAllowedHttpException();
	}


	/**
	 * {@inheritdoc}
	 */
	protected function verbs(): array
	{
		return [
			'index' => ['get', 'options'],
			'vote' => ['post', 'delete', 'options'],
			'create' => ['post', 'options'],
		];
	}

}
