<?php

namespace api\controllers;

use api\models\SignupForm;
use api\models\VerifyConfirmCode;
use backend\firebase\FirebaseNotifications;
use common\components\PayComponent;
use common\models\ChatSubscrib;
use common\models\DonatePay;
use common\models\OrdersApp;
use common\models\Tokens;
use common\models\User;
use frontend\models\PasswordResetRequestForm;
use InvalidArgumentException;
use Throwable;
use YandexCheckout\Common\Exceptions\ApiException;
use YandexCheckout\Common\Exceptions\BadApiRequestException;
use YandexCheckout\Common\Exceptions\ForbiddenException;
use YandexCheckout\Common\Exceptions\InternalServerError;
use YandexCheckout\Common\Exceptions\NotFoundException;
use YandexCheckout\Common\Exceptions\ResponseProcessingException;
use YandexCheckout\Common\Exceptions\TooManyRequestsException;
use YandexCheckout\Common\Exceptions\UnauthorizedException;
use YandexCheckout\Model\Notification\NotificationCanceled;
use YandexCheckout\Request\Payments\CreatePaymentResponse;
use YandexCheckout\Model\Notification\NotificationSucceeded;
use YandexCheckout\Model\NotificationEventType;
use Yii;
use yii\base\Exception;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\rest\Controller;
use api\models\LoginForm;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;
use yii\filters\Cors;

/**
 * Site controller
 */
class SiteController extends Controller
{

	/**
	 * {@inheritdoc}
	 */
	public function behaviors(): array
	{
		$behaviors = parent::behaviors();

		$auth = $behaviors['authenticator'];

		unset($behaviors['authenticator']);

		// add CORS filter
		$behaviors['corsFilter'] = [
			'class' => Cors::class,
			'cors' => [
				'Origin' => ['*'],
				'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
				'Access-Control-Request-Headers' => ['*'],
			],
		];

		// re-add authentication filter
		$behaviors['authenticator'] = $auth;

		// avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
		$behaviors['authenticator']['except'] = ['options'];

		$behaviors['access'] = [
			'class' => AccessControl::className(),
			'rules' => [
				[
					'actions' => ['pay-notification'],
					'allow' => true,
					'roles' => ['?'],
					'ips' => [
						'185.71.76.*',
						'185.71.77.*',
						'77.75.153.*',
						'77.75.154.*',
						'2a02:5180:0:1509:*',
						'2a02:5180:0:2655:*',
						'2a02:5180:0:1533:*',
						'2a02:5180:0:2669:*',
					]
				],
				[
					'actions' => ['pay-notification'],
					'allow' => false,
					'roles' => ['?'],
				],
				[
					'allow' => true,
					'roles' => ['?'],
				],
			]
		];

		return $behaviors;
	}

	/**
	 * @return string
	 * @throws ApiException
	 * @throws BadApiRequestException
	 * @throws BadRequestHttpException
	 * @throws ForbiddenException
	 * @throws InternalServerError
	 * @throws NotFoundException
	 * @throws ResponseProcessingException
	 * @throws TooManyRequestsException
	 * @throws UnauthorizedException
	 * @throws Throwable
	 * @throws StaleObjectException
	 */
	public function actionPayNotification(): string
	{
		$requestBody = Yii::$app->request->post();

		try {
			$notification = ($requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
				? new NotificationSucceeded($requestBody)
				: new NotificationCanceled($requestBody);
		} catch (Exception $e) {
			throw new BadRequestHttpException('Bad request');
		}

		$paymentNotification = $notification->getObject();

		/** @var PayComponent $payComponent */
		$payComponent = Yii::$app->pay;
		/** @var CreatePaymentResponse $payment */
		$payment = $payComponent->client->getPaymentInfo($paymentNotification->id);

		if ($payment->status === $paymentNotification->status){
			$notific = new FirebaseNotifications();
			$notification = [
				"title" => 'Пожертвования',
				"body" => 'Спасибо! Ваше пожертование получено.',
				"sound" => "default",
				"click_action" => "FCM_PLUGIN_ACTIVITY"
			];
			if ($model = DonatePay::findOne(['pay_id' => $payment->id])) {
				if ($model->status === DonatePay::STAT_SUCCEEDED){
					if ($user = $model->user) {
						$notific->sendNotification("/topics/chat_user_{$user->profile->id}", $notification, null);
					}
					return 'success no changed donate';
				}

				if ($payment->status === 'succeeded') {
					$model->status = DonatePay::STAT_SUCCEEDED;
					if ($user = $model->user) {
						$amount = (int)$payment->amount->value;
						$profile = $user->profile;
						$profile->last_donate = $amount;
						$profile->all_donate += $amount;
						$profile->update();
						$notific->sendNotification("/topics/chat_user_{$user->profile->id}", $notification, null);
					}
					if ($donate = $model->donate) {
						$donate->now += $model->amount;
						++$donate->donate_count;
						$donate->update();
					}
					if ($model->update()){
						return 'success succeeded donate';
					}
				}

				if ($payment->status === 'canceled') {
					if ($model->delete()){
						return 'success deleted donate';
					}
				}
			}

			if ($model = OrdersApp::findOne(['pay_id' => $payment->id])) {
				if ($model->status === OrdersApp::STAT_SUCCEEDED){
					if ($user = $model->user) {
						$notific->sendNotification("/topics/chat_user_{$user->profile->id}", $notification, null);
					}
					return 'success not changed orders';
				}

				if ($payment->status === 'canceled') {
					if ($model->delete()){
						return 'success deleted orders';
					}
				}

				if ($payment->status === 'succeeded') {
					$model->status = OrdersApp::STAT_SUCCEEDED;
					if ($user = $model->user) {
						$amount = (int)$payment->amount->value;
						$profile = $user->profile;
						$profile->last_donate = $amount;
						$profile->all_donate += $amount;
						$profile->update();
						$notific->sendNotification("/topics/chat_user_{$user->profile->id}", $notification, null);
					}
					if ($model->update()){
						return 'success succeeded orders';
					}
				}
			}

			return 'not found';
		}

		throw new BadRequestHttpException('Not allowed');
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex(): string
	{
		return 'api';
	}

	/**
	 * @param $token
	 * @return string
	 */
	public function actionChatSubscrib($token): string
	{
		if ($chekToken = ChatSubscrib::findOne(['token' => $token])) {
			return 'success';
		}

		$model = new ChatSubscrib([
			'token' => $token
		]);

		if ($model->save()) {
			return 'success';
		}
		return 'fail';
	}

	/**
	 * @return LoginForm|array|Tokens
	 * @throws Exception
	 */
	public function actionLogin()
	{
		$model = new LoginForm();
		$model->load(Yii::$app->request->bodyParams, '');

		if ($token = $model->auth()) {
			return $token;
		}
		return $model;
	}

	/**
	 * Signs user up.
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function actionSignup()
	{
		$model = new SignupForm();
		if ($model->load(Yii::$app->request->bodyParams, '') && $model->signup()) {
			$response = Yii::$app->getResponse();
			$response->setStatusCode(201);
		} elseif (!$model->hasErrors()) {
			throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
		}
		return $model;
	}

	/**
	 * Verify email address
	 *
	 * @param int $code
	 * @param $username
	 * @return Tokens|VerifyConfirmCode
	 * @throws BadRequestHttpException
	 * @throws Exception
	 */
	public function actionVerifyCode($code, $username)
	{
		try {
			$model = new VerifyConfirmCode($code, $username);
		} catch (InvalidArgumentException $e) {
			throw new BadRequestHttpException($e->getMessage());
		}

		if ($user = $model->verifyCode()) {
			if ($token = $user->auth()) {
				return $token;
			}
		}

		return $model;
	}

	/**
	 * @param $username
	 * @return bool
	 * @throws \Exception
	 */
	public function actionResendCode($username): bool
	{
		if ($user = User::findOne(['username' => $username])) {
			return $user->resendCode();
		}

		throw new NotFoundHttpException('Пользователь не найден');
	}

	/**
	 * Requests password reset.
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function actionRequestPasswordReset()
	{
		$model = new PasswordResetRequestForm();
		if ($model->load(Yii::$app->request->bodyParams, '') && $model->validate()) {
			if ($model->sendEmail()) {
				$mess = 'Проверьте свою электронную почту для дальнейших инструкций';
			} else {
				$mess = 'Извините, мы не можем сбросить пароль для указанного адреса электронной почты';
			}
			return ['message' => $mess];
		}

		throw new BadRequestHttpException('Некоректный запрос');
	}

	/**
	 * @param $id
	 * @return Response
	 * @throws ApiException
	 * @throws BadApiRequestException
	 * @throws ForbiddenException
	 * @throws InternalServerError
	 * @throws NotFoundException
	 * @throws ResponseProcessingException
	 * @throws TooManyRequestsException
	 * @throws UnauthorizedException
	 * @throws Throwable
	 * @throws StaleObjectException
	 */
	public function actionServicePayCheck($id): Response
	{
		$model = OrdersApp::findOne(['id' => $id]);

		if ($model) {
			/** @var PayComponent $payComponent */
			$payComponent = Yii::$app->pay;
			/** @var CreatePaymentResponse $payment */
			$payment = $payComponent->client->getPaymentInfo($model->pay_id);
			if ($payment->status === 'canceled') {
				$model->delete();
				return $this->redirect('https://' . Yii::$app->request->hostName . '/close/canceled');
			}

			if ($payment->status === 'succeeded') {
				$model->status = OrdersApp::STAT_SUCCEEDED;
				$user = $model->user;
				if ($user !== null) {
					$amount = (int)$payment->amount->value;
					$profile = $user->profile;
					$profile->last_donate = $amount;
					$profile->all_donate += $amount;
					$profile->update();
				}

			} else {
				$model->status = OrdersApp::STAT_UNDEFINED;
			}
			$model->update();
		}
		return $this->redirect('https://' . Yii::$app->request->hostName . '/close');
	}

	/**
	 * @param $id
	 * @return array
	 * @throws ApiException
	 * @throws BadApiRequestException
	 * @throws ForbiddenException
	 * @throws InternalServerError
	 * @throws NotFoundException
	 * @throws ResponseProcessingException
	 * @throws TooManyRequestsException
	 * @throws UnauthorizedException
	 * @throws Throwable
	 * @throws StaleObjectException
	 */
	public function actionServicePayCheckOnExit($id): array
	{
		$model = OrdersApp::findOne(['id' => $id]);

		if ($model) {
			/** @var PayComponent $payComponent */
			$payComponent = Yii::$app->pay;
			/** @var CreatePaymentResponse $payment */
			$payment = $payComponent->client->getPaymentInfo($model->pay_id);
			if ($payment->status === 'canceled') {
				$model->delete();
				return [
					'status' => 'canceled',
					'error' => 'Не удалось принять пожертвование.',
				];
			}

			if ($payment->status === 'succeeded') {
				$model->status = OrdersApp::STAT_SUCCEEDED;
				$user = $model->user;
				if ($user !== null) {
					$amount = (int)$payment->amount->value;
					$profile = $user->profile;
					$profile->last_donate = $amount;
					$profile->all_donate += $amount;
					$profile->update();
				}

			} else {
				$model->status = OrdersApp::STAT_UNDEFINED;
				return [
					'status' => 'other',
				];
			}
			$model->update();
		}
		return [
			'status' => 'succeeded',
		];
	}

	/**
	 * @param $id
	 * @return Response
	 * @throws ApiException
	 * @throws BadApiRequestException
	 * @throws ForbiddenException
	 * @throws InternalServerError
	 * @throws NotFoundException
	 * @throws ResponseProcessingException
	 * @throws TooManyRequestsException
	 * @throws UnauthorizedException
	 * @throws Throwable
	 * @throws StaleObjectException
	 */
	public function actionDonatePayCheck($id): Response
	{
		$model = DonatePay::findOne(['id' => $id]);

		if ($model) {
			/** @var PayComponent $payComponent */
			$payComponent = Yii::$app->pay;
			/** @var CreatePaymentResponse $payment */
			$payment = $payComponent->client->getPaymentInfo($model->pay_id);
			if ($payment->status === 'canceled') {
				$model->delete();
				return $this->redirect('https://' . Yii::$app->request->hostName . '/close/canceled');
			}

			if ($payment->status === 'succeeded') {
				$model->status = DonatePay::STAT_SUCCEEDED;
				if ($user = $model->user) {
					$amount = (int)$payment->amount->value;
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
			} else {
				$model->status = OrdersApp::STAT_UNDEFINED;
			}
			$model->update();
		}
		return $this->redirect('https://' . Yii::$app->request->hostName . '/close');
	}

	/**
	 * @param $id
	 * @return array
	 * @throws ApiException
	 * @throws BadApiRequestException
	 * @throws ForbiddenException
	 * @throws InternalServerError
	 * @throws NotFoundException
	 * @throws ResponseProcessingException
	 * @throws TooManyRequestsException
	 * @throws UnauthorizedException
	 * @throws Throwable
	 * @throws StaleObjectException
	 */
	public function actionDonatePayCheckOnExit($id): array
	{
		$model = DonatePay::findOne(['id' => $id]);

		if ($model) {
			/** @var PayComponent $payComponent */
			$payComponent = Yii::$app->pay;
			/** @var CreatePaymentResponse $payment */
			$payment = $payComponent->client->getPaymentInfo($model->pay_id);
			if ($payment->status === 'canceled') {
				$model->delete();
				return [
					'status' => 'canceled',
					'error' => 'Не удалось принять пожертвование.',
				];
			}

			if ($payment->status === 'succeeded') {
				$model->status = DonatePay::STAT_SUCCEEDED;
				if ($user = $model->user) {
					$amount = (int)$payment->amount->value;
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
			} else {
				$model->status = OrdersApp::STAT_UNDEFINED;
				return [
					'status' => 'other',
				];
			}
			$model->update();
		}
		return [
			'status' => 'succeeded',
		];
	}


	/**
	 * {@inheritdoc}
	 */
	protected function verbs(): array
	{
		return [
			'login' => ['post'],
			'signup' => ['post'],
			'verify-code' => ['get'],
			'resend-code' => ['get'],
			'request-password-reset' => ['post'],
			'chat-subscrib' => ['GET'],
			'service-pay-check' => ['GET'],
			'service-pay-check-on-exit' => ['GET'],
			'donate-pay-check' => ['GET'],
			'donate-pay-check-on-exit' => ['GET'],
		];
	}
}
