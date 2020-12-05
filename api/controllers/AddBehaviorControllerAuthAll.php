<?php

namespace api\controllers;

use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\filters\Cors;

/**
 * Site controller
 */
class AddBehaviorControllerAuthAll extends ActiveController
{

	public function behaviors(): array
	{
		$behaviors = parent::behaviors();

		$auth = $behaviors['authenticator'];

		unset($behaviors['authenticator']);

		// add CORS filter
		$behaviors['corsFilter'] = [
			'class' => Cors::class,
			'cors' => [
				'Origin' => ['*'],
				'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
				'Access-Control-Request-Headers' => ['*'],
			],
		];

		// re-add authentication filter
		$behaviors['authenticator'] = $auth;
		// avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
		$behaviors['authenticator']['except'] = ['options'];

		$behaviors['authenticator']['authMethods'] = [
			HttpBasicAuth::className(),
			HttpBearerAuth::className(),
		];

		$behaviors['access'] = [
			'class' => AccessControl::className(),
			'rules' => [
				[
					'allow' => true,
					'roles' => ['@'],
				],
			]
		];

		return $behaviors;
	}

}
