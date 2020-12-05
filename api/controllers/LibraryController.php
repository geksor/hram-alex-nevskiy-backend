<?php

namespace api\controllers;

use api\models\LibraryApi;
use Yii;

/**
 * Site controller
 */
class LibraryController extends AddBehaviorJsonController
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

	public function actionIndex(): LibraryApi
	{

		$model = new LibraryApi();
		$model->load(Yii::$app->params);
		return $model;
	}

}
