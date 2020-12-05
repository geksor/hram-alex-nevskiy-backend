<?php

namespace api\controllers;

use api\models\HistoryApi;
use Yii;

/**
 * Site controller
 */
class HistoryController extends AddBehaviorJsonController
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

	public function actionIndex(): HistoryApi
	{

		$model = new HistoryApi();
		$model->load(Yii::$app->params);
		return $model;
	}

}
