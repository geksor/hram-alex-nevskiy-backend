<?php

namespace api\controllers;

use common\components\PayComponent;
use common\models\OrdersApp;
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
use yii\db\StaleObjectException;

/**
 * Site controller
 */
class PayServiceController extends AddBehaviorController
{
	public $modelClass = OrdersApp::class;

	public function actions()
	{
		$actions = parent::actions();

		unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);

		return $actions;
	}

	/**
	 * @return mixed
	 * @throws Throwable
	 * @throws StaleObjectException
	 */
	public function actionCreate()
	{
		$amount = Yii::$app->request->post('amount');
		$desk = Yii::$app->request->post('desk');

		if ($amount && $desk) {
			$model = new OrdersApp();

			$model->user_id = Yii::$app->user->id;

			$model->load(Yii::$app->request->bodyParams, '');

			if ($model->save()) {

				$link = "/api/service-pay-check/{$model->id}";
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
						$model->status = OrdersApp::STAT_PENDING;
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
							'error' => 'Не удальсь обработать требу.',
						];
					}

					$user = $model->user;
					if ($user !== null) {
						$profile = $user->profile;
						$profile->last_donate = $amount;
						$profile->all_donate += $amount;
						$profile->update();
					}

					$model->pay_id = $payObject->id;
					$model->status = OrdersApp::STAT_SUCCEEDED;
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
			'create' => ['post', 'options'],
		];
	}

}
