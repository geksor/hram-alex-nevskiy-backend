<?php

namespace api\controllers;

use api\models\NewsApi;
use yii\data\ActiveDataProvider;
use yii\rest\Serializer;

/**
 * Site controller
 */
class NewsController extends AddBehaviorController
{
	public $modelClass = NewsApi::class;
	public $serializer = [
		'class' => Serializer::class,
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
			'query' => NewsApi::find()->active()->orderByPublish(),
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
