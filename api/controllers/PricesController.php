<?php

namespace api\controllers;

use api\models\PriceApi;
use yii\data\ActiveDataProvider;

/**
 * Site controller
 */
class PricesController extends AddBehaviorController
{
	public $modelClass = PriceApi::class;

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
			'query' => PriceApi::find()->active()->orderRank()->withItem()
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
