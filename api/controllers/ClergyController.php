<?php

namespace api\controllers;

use api\models\ClergyListApi;
use yii\data\ActiveDataProvider;
use api\models\ClergyApi;

/**
 * Site controller
 */
class ClergyController extends AddBehaviorController
{
	public $modelClass = ClergyApi::class;

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
			'query' => ClergyListApi::find()->active()->orderName()
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
