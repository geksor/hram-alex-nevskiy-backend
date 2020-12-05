<?php

namespace api\controllers;

use api\models\SliderApi;
use yii\data\ActiveDataProvider;

/**
 * Site controller
 */
class SliderController extends AddBehaviorController
{
	public $modelClass = SliderApi::class;

	/**
	 * {@inheritdoc}
	 */
	public function actions()
	{
		$actions = parent::actions();

		unset($actions['create'], $actions['update'], $actions['delete'], $actions['view']);

		$actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

		return $actions;
	}

	public function prepareDataProvider(): ActiveDataProvider
	{
		return new ActiveDataProvider([
			'query' => SliderApi::find()->active()->orderRank()
		]);
	}


	/**
	 * {@inheritdoc}
	 */
	protected function verbs(): array
	{
		return [
			'index' => ['get'],
		];
	}

}
