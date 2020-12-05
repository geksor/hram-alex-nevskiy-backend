<?php

namespace api\controllers;

use api\models\BlogApi;
use yii\data\ActiveDataProvider;

/**
 * Site controller
 */
class BlogController extends AddBehaviorController
{
	public $modelClass = BlogApi::class;
	public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'items',
	];


	/**
	 * {@inheritdoc}
	 */
	public function actions(): array
	{
		$actions = parent::actions();

		unset($actions['create'], $actions['update'], $actions['delete']);

		$actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

		return $actions;
	}

	public function prepareDataProvider(): ActiveDataProvider
	{
		return new ActiveDataProvider([
			'query' => BlogApi::find()->active()->orderByPublish(),
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
