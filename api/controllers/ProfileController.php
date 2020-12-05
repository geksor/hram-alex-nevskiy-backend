<?php

namespace api\controllers;

use api\models\ProfileApi;
use common\models\Tokens;
use common\rbac\Rbac;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class ProfileController extends AddBehaviorControllerAuthAll
{
	public $modelClass = ProfileApi::class;

	/**
	 * {@inheritdoc}
	 */
	public function actions()
	{
		$actions = parent::actions();

		unset($actions['index'], $actions['view'], $actions['create'], $actions['delete']);

		return $actions;
	}

	/**
	 * @param string $action
	 * @param null $model
	 * @param array $params
	 * @throws ForbiddenHttpException
	 */
	public function checkAccess($action, $model = null, $params = []): void
	{
		if ($action === 'update') {
			if (!Yii::$app->user->can(Rbac::MANAGE_OWNER_PROFILE, ['profile' => $model])) {
				throw new ForbiddenHttpException('Отказано в доступе');
			}
		}
	}

	/**
	 * @return ProfileApi|string|null
	 * @throws NotFoundHttpException
	 */
	public function actionIndex()
	{
		if (Yii::$app->request->isOptions) {
			$response = Yii::$app->getResponse();
			$response->setStatusCode(200);
			return 'ok';
		}

		if ($model = ProfileApi::findOne(['user_id' => Yii::$app->user->id])) {
			return $model;
		}
		throw new NotFoundHttpException('Профиль не найден');
	}

	/**
	 * @return string
	 */
	public function actionLogoutAll(): string
	{
		if (Yii::$app->request->isOptions) {
			$response = Yii::$app->getResponse();
			$response->setStatusCode(200);
			return 'ok';
		}

		Tokens::deleteAll(['user_id' => Yii::$app->user->id]);

		return 'ok';
	}

	/**
	 * @return string
	 */
	public function actionLogout(): string
	{
		if (Yii::$app->request->isOptions) {
			$response = Yii::$app->getResponse();
			$response->setStatusCode(200);
			return 'ok';
		}

		$request = Yii::$app->request->headers;
		$token = preg_replace('/Bearer /', '', $request['authorization']);

		Tokens::deleteAll(['token' => $token]);

		return 'ok';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function verbs(): array
	{
		return [
			'index' => ['get', 'options'],
			'logout-all' => ['get', 'options'],
			'logout' => ['get', 'options'],
			'update' => ['PUT'],
		];
	}

}
