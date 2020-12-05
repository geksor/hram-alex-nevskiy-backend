<?php

namespace api\controllers;

use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

/**
 * Site controller
 */
class AddBehaviorController extends ActiveController
{

	public function behaviors(): array
	{
		$behaviors = parent::behaviors();

		$auth = $behaviors['authenticator'];

		unset($behaviors['authenticator']);

		// add CORS filter
		$behaviors['corsFilter'] = [
			'class' => '\yii\filters\Cors',
			'cors' => [
				'Origin' => ['*'],
				'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
				'Access-Control-Request-Headers' => ['*'],
			],
		];

		// re-add authentication filter
		$behaviors['authenticator'] = $auth;
		$behaviors['authenticator']['only'] = ['update', 'create', 'delete', 'vote'];
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
					'actions' => ['update', 'create', 'delete', 'vote'],
					'allow' => true,
					'roles' => ['@'],
				],
				[
					'actions' => ['update', 'create', 'delete', 'vote'],
					'allow' => false,
					'roles' => ['?'],
				],
				[
					'allow' => true,
					'roles' => ['?'],
				],
			]
		];

		return $behaviors;
	}

}
