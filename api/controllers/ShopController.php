<?php

namespace api\controllers;

use api\models\ShopApi;
use Yii;

/**
 * Site controller
 */
class ShopController extends AddBehaviorJsonController
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

	public function actionIndex(): ShopApi
	{

		$model = new ShopApi();
		$model->load(Yii::$app->params);
		return $model;
	}

}
