<?php

namespace api\controllers;

use api\models\BlogSecondApi;
use yii\data\ActiveDataProvider;

/**
 * Site controller
 */
class BlogSecondController extends AddBehaviorController
{
	public $modelClass = BlogSecondApi::class;
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
			'query' => BlogSecondApi::find()->active()->orderByPublish(),
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
