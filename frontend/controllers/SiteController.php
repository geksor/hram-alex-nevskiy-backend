<?php

namespace frontend\controllers;

use common\models\History;
use common\models\Contact;
use DateTimeZone;
use frontend\models\ResetPasswordForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\helpers\VarDumper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;

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
		];
	}

	/**
	 * Displays homepage.
	 *
	 * @return mixed
	 */
	public function actionIndex()
	{
		return $this->render('index');
	}

	/**
	 * Displays homepage.
	 *
	 * @return mixed
	 */
	public function actionClose()
	{
		Yii::$app->session->setFlash('close');
		return $this->render('index');
	}

	/**
	 * Displays homepage.
	 *
	 * @return mixed
	 */
	public function actionCanceled()
	{
		Yii::$app->session->setFlash('canceled');
		return $this->render('index');
	}

	/**
	 * Resets password.
	 *
	 * @param string $token
	 * @return mixed
	 * @throws BadRequestHttpException
	 * @throws \yii\base\Exception
	 */
	public function actionResetPassword($token)
	{
		try {
			$model = new ResetPasswordForm($token);
		} catch (InvalidArgumentException $e) {
			throw new BadRequestHttpException($e->getMessage());
		}

		if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
			Yii::$app->session->setFlash('success', 'Пароль изменен.');

			return $this->goHome();
		}

		return $this->render('resetPassword', [
			'model' => $model,
		]);
	}

}
