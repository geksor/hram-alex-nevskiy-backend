<?php

namespace api\controllers;

use api\models\CalendarApi;
use api\models\CalendarDayApi;
use common\models\CalendarEvents;
use Exception;
use Yii;

/**
 * Site controller
 */
class CalendarController extends AddBehaviorController
{
	public $modelClass = CalendarApi::class;

	public function actions()
	{
		$actions = parent::actions();

		unset($actions['index'], $actions['create'], $actions['update'], $actions['delete']);

		return $actions;
	}

	/**
	 * @param $timezone
	 * @param $date
	 * @return CalendarApi[]|array|CalendarEvents[]
	 * @throws Exception
	 */
	public function actionIndex($timezone, $date): array
	{
		$models = CalendarApi::find()->active()->filterMonth($date)->all();
		foreach ($models as $model) {
			$model->timezone = $timezone;
		}
		return $models;
	}

	/**
	 * @param $date
	 * @return CalendarDayApi[]|array|CalendarEvents[]
	 * @throws Exception
	 */
	public function actionDayEvents($date): array
	{
		$strDate = Yii::$app->formatter->asDate($date, 'long');

		$models = CalendarDayApi::find()->active()->filterDay($date)->all();

		foreach ($models as $model) {
			$model->date = $strDate;
		}

		return $models;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function verbs(): array
	{
		return [
			'index' => ['get'],
			'day-events' => ['get'],
		];
	}

}
