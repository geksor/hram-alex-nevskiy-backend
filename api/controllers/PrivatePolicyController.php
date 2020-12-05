<?php

namespace api\controllers;

use api\models\PrivatePolicyApi;
use Yii;

/**
 * Site controller
 */
class PrivatePolicyController extends AddBehaviorJsonController
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

	public function actionIndex(): PrivatePolicyApi
	{
		$model = new PrivatePolicyApi();
		$model->load(Yii::$app->params);
		return $model;
	}
}
