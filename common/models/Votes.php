<?php

namespace common\models;

use backend\firebase\FirebaseNotifications;
use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "votes".
 *
 * @property int $id
 * @property int $user_id
 * @property string $user_name
 * @property string $title
 * @property string $text
 * @property int $type
 * @property int $publish
 * @property int $publish_at
 * @property int $created_at
 * @property int $updated_at
 * @property int $view
 * @property int $votesCount
 * @property int $sended
 *
 * @property User $user
 * @property VotesUsersCount[] $votesUsersCounts
 * @property User[] $users
 *
 * @property string $pubDateToForm
 */
class Votes extends \yii\db\ActiveRecord
{
	const TYPE_USER = 1;
	const TYPE_ADMIN = 2;
	const NAME_ADMIN = 'Администрация';

	protected $typeName = [
		self::TYPE_USER => 'Предложение от пользователя',
		self::TYPE_ADMIN => 'Предложение от администрации'
	];

	public $pubDateToForm;

	/**
	 * @throws \yii\base\InvalidConfigException
	 */
	public function afterFind()
	{
		parent::afterFind();

		$this->pubDateToForm = $this->publish_at ? Yii::$app->formatter->asDate($this->publish_at, 'dd-MM-yyyy') : null;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'votes';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['user_id', 'title', 'text'], 'required'],
			[['user_id', 'type', 'publish', 'publish_at', 'created_at', 'updated_at', 'view', 'votesCount', 'sended'], 'integer'],
			[['text', 'pubDateToForm'], 'string'],
			[['user_name', 'title'], 'string', 'max' => 255],
			[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
			[['view'], 'default', 'value' => 0],
			[['votesCount'], 'default', 'value' => 0],
			[['publish'], 'default', 'value' => 0],
			[['user_id'], 'default', 'value' => Yii::$app->user->id],
			[['text', 'title'], 'filter', 'filter' => function ($value) {
				if (Yii::$app->user->can('manager')) {
					return $value;
				}
				return Html::encode($value);
			}],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'user_id' => 'User ID',
			'user_name' => 'User Name',
			'title' => 'Title',
			'text' => 'Text',
			'type' => 'Type',
			'publish' => 'Publish',
			'publish_at' => 'Publish At',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'view' => 'View',
			'pubDateToForm' => 'Publish At',
			'votesCount' => 'Кол-во голосов',
			'sended' => 'Sended',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getVotesUsersCounts()
	{
		return $this->hasMany(VotesUsersCount::className(), ['votes_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 * @throws \yii\base\InvalidConfigException
	 */
	public function getUsers()
	{
		return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('votes_users_count', ['votes_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 * @throws \yii\base\InvalidConfigException
	 */
	public function getUserById($id)
	{
		return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('votes_users_count', ['votes_id' => 'id']);
	}

	/**
	 * {@inheritdoc}
	 * @return \common\models\query\VotesQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \common\models\query\VotesQuery(get_called_class());
	}

	/**
	 * @return bool
	 */
	public function beforeValidate()
	{
		if (!$this->user_id) {
			$this->user_id = Yii::$app->user->id;
		}

		return parent::beforeValidate();
	}

	/**
	 * @throws \Exception
	 */
	public function sendNotice()
	{
		if ((!$this->sended || $this->sended === 0) && $this->publish) {
			$notific = new FirebaseNotifications();

			$title = 'Опубликованно новое предложение';
			$body = $this->title;
			$link = '/votes/';

			$notification = [
				"title" => $title,
				"body" => $body,
				"sound" => "default",
				"click_action" => "FCM_PLUGIN_ACTIVITY"
			];
			$data = [
				"link" => $link
			];

			if ($notific->sendNotification('/topics/all', $notification, $data)) {
				$this->sended = 1;
			};
		}
	}

	/**
	 * @param bool $insert
	 * @return bool
	 * @throws \Exception
	 */
	public function beforeSave($insert)
	{
		if ($this->created_at) {

			$this->updated_at = time();

			$this->created_at =
				is_string($this->created_at)
					? strtotime($this->created_at)
					: $this->created_at;
		} else {
			$this->created_at = time();
		}

		if ($this->pubDateToForm) {

			$this->publish_at =
				is_string($this->pubDateToForm)
					? Yii::$app->formatter->asTimestamp($this->pubDateToForm)
					: $this->publish_at;

		} elseif ($this->publish) {

			$this->publish_at = time();

		}

		if (!$this->type) {
			if (Yii::$app->user->can('manager')) {
				$this->type = self::TYPE_ADMIN;
				$this->user_name = self::NAME_ADMIN;
			} else {
				$this->type = self::TYPE_USER;
				$this->user_name = Profile::findOne(['user_id' => Yii::$app->user->id])->name;
			}
		}

		if ($this->votesCount === null) {
			$this->votesCount = 0;
		}

		$this->sendNotice();

		return parent::beforeSave($insert);
	}

}
