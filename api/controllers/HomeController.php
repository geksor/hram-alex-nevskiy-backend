<?php

namespace api\controllers;

use common\models\EventForHome;
use phpDocumentor\Reflection\Types\Array_;
use yii\data\ActiveDataProvider;

/**
 * Site controller
 */
class HomeController extends AddBehaviorController
{
	public $modelClass = 'common\models\EventForHome';
	public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'items',
	];

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
			'query' => EventForHome::find()->active()->rankPublish(),
			'pagination' => [
				'pageSize' => 6,
			]
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
