<?php

namespace api\controllers;

use api\models\DonateApi;
use common\components\PayComponent;
use common\models\DonatePay;
use common\models\User;
use Throwable;
use YandexCheckout\Common\Exceptions\ApiException;
use YandexCheckout\Common\Exceptions\BadApiRequestException;
use YandexCheckout\Common\Exceptions\ForbiddenException;
use YandexCheckout\Common\Exceptions\InternalServerError;
use YandexCheckout\Common\Exceptions\NotFoundException;
use YandexCheckout\Common\Exceptions\ResponseProcessingException;
use YandexCheckout\Common\Exceptions\TooManyRequestsException;
use YandexCheckout\Common\Exceptions\UnauthorizedException;
use YandexCheckout\Model\Confirmation\ConfirmationRedirect;
use YandexCheckout\Request\Payments\CreatePaymentResponse;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\web\ServerErrorHttpException;

/**
 * Site controller
 */
class DonateController extends AddBehaviorController
{
	public $modelClass = DonateApi::class;

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
			'query' => DonateApi::find()->active()->orderRank()
		]);
	}

	/**
	 * @return mixed
	 * @throws StaleObjectException
	 * @throws Throwable
	 */
	public function actionCreate()
	{
		$amount = Yii::$app->request->post('amount');
		$desk = Yii::$app->request->post('desk');
		$donateId = Yii::$app->request->post('donate_id');

		if ($amount && $desk && $donateId) {
			$model = new DonatePay();

			$model->user_id = Yii::$app->user->id;

			$model->load(Yii::$app->request->bodyParams, '');

			if ($model->save()) {

				$link = "/api/donate-pay-check/{$model->id}";
				/** @var PayComponent $payComponent */
				$payComponent = Yii::$app->pay;

				try {
					/** @var CreatePaymentResponse $payObject */
					$payObject = $payComponent->createPayment($amount, $desk, $link);
				} catch (ApiException|BadApiRequestException
				|ForbiddenException|InternalServerError
				|NotFoundException|ResponseProcessingException
				|TooManyRequestsException|UnauthorizedException $exception) {
					$model->delete();
					return $exception;
				}

				if ($payObject) {
					if ($payObject->status === 'canceled') {
						$error = $payComponent->getErrorsArr($payObject->cancellationDetails->reason);
						$model->delete();
						return [
							'status' => $payObject->status,
							'error' => $error,
						];
					}

					if ($payObject->status === 'pending') {
						$model->pay_id = $payObject->id;
						$model->status = DonatePay::STAT_PENDING;
						/** @var ConfirmationRedirect $confirmation */
						$confirmation = $payObject->confirmation;
						if ($model->update() !== false) {
							return [
								'status' => $payObject->status,
								'confirmation_url' => $confirmation->confirmationUrl,
								'close_url' => Yii::$app->request->hostInfo . '/close',
								'close_url_canceled' => Yii::$app->request->hostInfo . '/close/canceled',
								'model_id' => $model->id,
							];
						}
						$model->delete();
						return [
							'status' => 'canceled',
							'error' => 'Не удальсь обработать пожертвование.',
						];
					}

					if ($user = $model->user) {
						$profile = $user->profile;
						$profile->last_donate = $amount;
						$profile->all_donate += $amount;
						$profile->update();
					}

					if ($donate = $model->donate) {
						$donate->now += $model->amount;
						++$donate->donate_count;
						$donate->update();
					}

					$model->pay_id = $payObject->id;
					$model->status = DonatePay::STAT_SUCCEEDED;
					$model->update();

					return [
						'status' => $payObject->status,
					];
				}

			} elseif (!$model->hasErrors()) {
				return [
					'status' => 'canceled',
					'error' => 'Не удалось обработать запрос по неизвестной причине.',
				];
			}
		}

		return [
			'status' => 'canceled',
			'error' => 'Некорректный запрос',
		];
	}


	/**
	 * {@inheritdoc}
	 */
	protected function verbs(): array
	{
		return [
			'index' => ['get', 'options'],
			'create' => ['post', 'options'],
		];
	}

}
