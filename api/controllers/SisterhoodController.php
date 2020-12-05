<?php

namespace api\controllers;

use api\models\SisterhoodApi;
use Yii;

/**
 * Site controller
 */
class SisterhoodController extends AddBehaviorJsonController
{
	/**
	 * {@inheritdoc}
	 */
	protected function verbs(): array
	{
		return [
			'index' => ['get', 'options'],
		];
	}

	public function actionIndex(): SisterhoodApi
	{
		$model = new SisterhoodApi();
		$model->load(Yii::$app->params);
		return $model;
	}

}
