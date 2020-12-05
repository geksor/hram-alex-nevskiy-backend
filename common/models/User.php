<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $confirm_code
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property int $role
 * @property bool $is_active
 *
 * @property ClergyQuestion[] $clergyQuestions
 * @property OrdersApp[] $ordersApps
 * @property Profile[] $profiles
 * @property Profile $profile
 * @property Tokens[] $tokens
 * @property Votes[] $votesSelf
 * @property VotesUsersCount[] $votesUsersCounts
 * @property Votes[] $votesCount
 */
class User extends ActiveRecord implements IdentityInterface
{
	const STATUS_DELETED = 0;
	const STATUS_INACTIVE = 9;
	const STATUS_ACTIVE = 10;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return '{{%user}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			['status', 'default', 'value' => self::STATUS_INACTIVE],
			['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'username' => 'Логин пользователя',
			'auth_key' => 'Ключ доступа',
			'password_hash' => 'Хэш пароля',
			'password_reset_token' => 'Пароль для сброса токена',
			'email' => 'Email',
			'status' => 'Статус',
			'created_at' => 'Дата создания',
			'updated_at' => 'Дата редактирования',
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public static function findIdentity($id)
	{
		return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * {@inheritdoc}
	 * @throws NotSupportedException
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		return static::find()
			->andWhere(['status' => self::STATUS_ACTIVE])
			->joinWith('tokens t')
			->andWhere(['t.token' => $token])
			->andWhere(['>', 't.expired_at', time()])
			->one();
	}

	/**
	 * Finds user by verification email token
	 *
	 * @param int $code confirm code
	 * @param $username
	 * @return static|null
	 */
	public static function findByConfirmCode($code, $username)
	{
		return static::findOne([
			'username' => $username,
			'confirm_code' => $code,
			'status' => self::STATUS_INACTIVE
		]);
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 * @return static|null
	 */
	public static function findByUsername($username)
	{
		return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * Finds user by password reset token
	 *
	 * @param string $token password reset token
	 * @return static|null
	 */
	public static function findByPasswordResetToken($token)
	{
		if (!static::isPasswordResetTokenValid($token)) {
			return null;
		}

		return static::findOne([
			'password_reset_token' => $token,
			'status' => self::STATUS_ACTIVE,
		]);
	}

	/**
	 * Finds out if password reset token is valid
	 *
	 * @param string $token password reset token
	 * @return bool
	 */
	public static function isPasswordResetTokenValid($token)
	{
		if (empty($token)) {
			return false;
		}

		$timestamp = (int)substr($token, strrpos($token, '_') + 1);
		$expire = Yii::$app->params['user.passwordResetTokenExpire'];
		return $timestamp + $expire >= time();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getId()
	{
		return $this->getPrimaryKey();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAuthKey()
	{
		return $this->auth_key;
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}

	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 * @return bool if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		return Yii::$app->security->validatePassword($password, $this->password_hash);
	}

	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 * @throws \yii\base\Exception
	 */
	public function setPassword($password)
	{
		$this->password_hash = Yii::$app->security->generatePasswordHash($password);
	}

	/**
	 * Generates "remember me" authentication key
	 * @throws \yii\base\Exception
	 */
	public function generateAuthKey()
	{
		$this->auth_key = Yii::$app->security->generateRandomString();
	}

	/**
	 * @throws \Exception
	 */
	public function generateConfirmCode()
	{
		$this->confirm_code = random_int(10000, 99999);
	}

	/**
	 * Generates new password reset token
	 * @throws \yii\base\Exception
	 */
	public function generatePasswordResetToken()
	{
		$this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
	}

	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken()
	{
		$this->password_reset_token = null;
	}

	public function getIs_active()
	{
		return $this->status !== self::STATUS_DELETED;
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getClergyQuestions()
	{
		return $this->hasMany(ClergyQuestion::className(), ['user_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getOrdersApps()
	{
		return $this->hasMany(OrdersApp::className(), ['user_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getProfiles()
	{
		return $this->hasMany(Profile::className(), ['user_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getProfile()
	{
		return $this->hasOne(Profile::className(), ['user_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTokens()
	{
		return $this->hasMany(Tokens::className(), ['user_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getVotesSelf()
	{
		return $this->hasMany(Votes::className(), ['user_id' => 'id']);
	}

	/**
	 * @param $id Votes id
	 * @return Votes|null
	 */
	public function getVotesSelfById($id): ?Votes
	{
		return Votes::findOne(['user_id' => 'id', 'id' => $id]);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getVotesUsersCounts()
	{
		return $this->hasMany(VotesUsersCount::className(), ['user_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 * @throws \yii\base\InvalidConfigException
	 */
	public function getVotesCount()
	{
		return $this->hasMany(Votes::className(), ['id' => 'votes_id'])->viaTable('votes_users_count', ['user_id' => 'id']);
	}

	/**
	 * {@inheritdoc}
	 * @return \common\models\query\UserQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \common\models\query\UserQuery(get_called_class());
	}

	/**
	 * @return Tokens|null
	 * @throws \yii\base\Exception
	 */
	public function auth()
	{
		if ($this->status === self::STATUS_ACTIVE) {
			$token = new Tokens();
			$token->user_id = $this->id;
			$token->generateToken(time() + \api\models\LoginForm::EXPIRE_TOKEN);
			return $token->save() ? $token : null;
		}

		return null;
	}

	public function delete()
	{
		if ($this->status === self::STATUS_INACTIVE) {
			return parent::delete();
		}
		$this->status = self::STATUS_DELETED;
		$this->save();
	}

	public function afterSave($insert, $changedAttributes)
	{
		if ($insert) {
			$profile = new Profile([
				'user_id' => $this->id
			]);
			$profile->save();
		}
		parent::afterSave($insert, $changedAttributes);
	}

	/**
	 * @return bool
	 * @throws \Throwable
	 * @throws \yii\db\StaleObjectException
	 */
	public function beforeDelete()
	{
		if ($this->profile) {
			$this->profile->delete();
		}
		return parent::beforeDelete();
	}

	/**
	 * @return bool
	 * @throws \Exception
	 */
	public function resendCode()
	{
		$this->generateConfirmCode();
		return $this->sendEmail() && $this->save();
	}

	/**
	 * Sends confirmation email to user
	 * @return bool whether the email was sent
	 */
	protected function sendEmail()
	{
		return Yii::$app
			->mailer
			->compose(
				['html' => 'codeVerifyReSend-html', 'text' => 'codeVerifyReSend-text'],
				['user' => $this]
			)
			->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
			->setTo($this->email)
			->setSubject('Account registration at ' . Yii::$app->name)
			->send();
	}
}
