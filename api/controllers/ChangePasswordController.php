<?php

namespace api\controllers;

use api\models\PasswordForm;
use Yii;
use yii\base\Exception;
use yii\web\ServerErrorHttpException;

/**
 * Site controller
 */
class ChangePasswordController extends AddBehaviorControllerAuthAll
{
	public $modelClass = PasswordForm::class;

	/**
	 * {@inheritdoc}
	 */
	public function actions()
	{
		$actions = parent::actions();

		unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);

		return $actions;
	}

	/**
	 * @return PasswordForm|null
	 * @throws Exception
	 */
	public function actionIndex(): ?PasswordForm
	{
		$model = new PasswordForm();
		$model->load(Yii::$app->request->bodyParams, '');

		if ($request = $model->updatePassword()) {
			return $request;
		}

		if (!$model->hasErrors()) {
			throw new ServerErrorHttpException('Что то пошло не так.');
		}
		return $model;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function verbs(): array
	{
		return [
			'index' => ['POST'],
		];
	}

}
