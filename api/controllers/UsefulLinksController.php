<?php

namespace api\controllers;

use api\models\UsefulLinksApi;
use yii\data\ActiveDataProvider;

/**
 * Site controller
 */
class UsefulLinksController extends AddBehaviorController
{
	public $modelClass = UsefulLinksApi::class;

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
			'query' => UsefulLinksApi::find()->active()->orderRank()
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
