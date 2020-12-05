<?php

namespace api\controllers;

use api\models\ServiceApi;
use yii\data\ActiveDataProvider;

/**
 * Site controller
 */
class ServiceController extends AddBehaviorController
{
	public $modelClass = ServiceApi::class;

	/**
	 * {@inheritdoc}
	 */
	public function actions()
	{
		$actions = parent::actions();

		unset($actions['create'], $actions['update'], $actions['delete']);

		$actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

		return $actions;
	}

	public function prepareDataProvider(): ActiveDataProvider
	{
		return new ActiveDataProvider([
			'query' => ServiceApi::find()->active()->orderRank()->withItem()
		]);
	}


	/**
	 * {@inheritdoc}
	 */
	protected function verbs(): array
	{
		return [
			'index' => ['get', 'options'],
		];
	}

}
