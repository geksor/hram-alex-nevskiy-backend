<?php

namespace api\controllers;

use api\models\ContactApi;
use Yii;

/**
 * Site controller
 */
class ContactController extends AddBehaviorJsonController
{
	/**
	 * @return array
	 */
	protected function verbs(): array
	{
		return [
			'index' => ['get', 'options'],
		];
	}

	public function actionIndex(): ContactApi
	{
		$model = new ContactApi();
		$model->load(Yii::$app->params);
		return $model;
	}

}
