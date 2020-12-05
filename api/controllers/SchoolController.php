<?php

namespace api\controllers;

use api\models\SchoolApi;
use Yii;

/**
 * Site controller
 */
class SchoolController extends AddBehaviorJsonController
{
	protected function verbs(): array
	{
		return [
			'index' => ['get', 'options'],
		];
	}

	public function actionIndex(): SchoolApi
	{
		$model = new SchoolApi();
		$model->load(Yii::$app->params);
		return $model;
	}

}
