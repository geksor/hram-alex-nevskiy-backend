<?php

namespace api\controllers;

use api\models\ChatApi;
use api\models\ProfileApi;
use common\models\Chat;
use Exception;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

/**
 * Site controller
 */
class ChatController extends AddBehaviorControllerAuthAll
{
	public $modelClass = ChatApi::class;

	/**
	 * {@inheritdoc}
	 */
	public function actions()
	{
		$actions = parent::actions();

		unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);

		return $actions;
	}


	/**
	 * @param null $last_date
	 * @return array|Chat[]
	 * @throws NotFoundHttpException
	 */
	public function actionIndex($last_date = null): array
	{
		if (!$profile = ProfileApi::findOne(['user_id' => Yii::$app->user->id])) {
			throw new NotFoundHttpException('Профиль не найден');
		}
		$query = ChatApi::find()->where(['profile_id' => $profile->id]);
		if ($last_date) {
			$query = $query->afterDate($last_date);
		}

		return $query->all();
	}

	/**
	 * @return array
	 * @throws NotFoundHttpException
	 */
	public function actionNoReed(): array
	{
		if (!$profile = ProfileApi::findOne(['user_id' => Yii::$app->user->id])) {
			throw new NotFoundHttpException('Профиль не найден');
		}

		$noReedMess = ChatApi::find()->where(['profile_id' => $profile->id, 'viewed' => null, 'type' => ChatApi::TYPE_ADMIN])->count();

		if ($noReedMess) {
			return [
				'noReed' => true
			];
		}

		return [
			'noReed' => false
		];
	}

	/**
	 * @return array
	 * @throws NotFoundHttpException
	 */
	public function actionSetReed(): array
	{
		if (!$profile = ProfileApi::findOne(['user_id' => Yii::$app->user->id])) {
			throw new NotFoundHttpException('Профиль не найден');
		}

		Chat::updateAll(['viewed' => 1], ['profile_id' => $profile->id, 'viewed' => null, 'type' => Chat::TYPE_ADMIN]);

		$noReedMess = ChatApi::find()->where(['profile_id' => $profile->id, 'viewed' => null, 'type' => ChatApi::TYPE_ADMIN])->count();

		if ($noReedMess) {
			return [
				'noReed' => true
			];
		}

		return [
			'noReed' => false
		];

	}

	/**
	 * {@inheritdoc}
	 * @throws BadRequestHttpException
	 * @throws Exception
	 */
	public function actionCreate()
	{
		$message = new ChatApi();
		$data = (object)Yii::$app->request->post();

		if (!isset($data->text)) {
			throw new BadRequestHttpException('Text required');
		}

		$profile = ProfileApi::findOne(['user_id' => Yii::$app->user->id]);
		$name = null;

		if (isset($data->profile_id)) {
			$message->profile_id = $data->profile_id;
		} elseif ($profile) {
			$message->profile_id = $profile->id;
			$name = $profile->name;
		} else {
			throw new BadRequestHttpException('Profile_id required');
		}

		$message->text = $data->text;
		$message->date = Yii::$app->formatter->asTimestamp('now');
		if (!isset($data->type)) {
			$message->type = Chat::TYPE_USER;
		} else {
			$message->type = $data->type;
		}

		if ($message->save() && ($return = $message->sendNotice($name))) {
			return $return;
		}
		throw new ServerErrorHttpException('Не удальсь отправить или сохранить сообщение');
	}

	/**
	 * {@inheritdoc}
	 */
	protected function verbs(): array
	{
		return [
			'index' => ['GET'],
			'no-reed' => ['GET'],
			'set-reed' => ['PUT'],
			'create' => ['POST'],
		];
	}

}
