<?php
namespace frontend\models;

use common\models\Tokens;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use common\models\User;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $confirmPassword;

    /**
     * @var \common\models\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidArgumentException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['confirmPassword', 'required'],
            ['confirmPassword', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'password' => 'Введите новый пароль',
            'confirmPassword' => 'Повторите новый пароль',
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     * @throws \yii\base\Exception
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        Tokens::deleteAll(['user_id' => $user->id]);

        return ($this->sendEmail($user->email) && $user->save(false));
    }

    protected function sendEmail($email)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetEnd-html', 'text' => 'passwordResetEnd-text'],
                ['password' => $this->password]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($email)
            ->setSubject('Новый пароль для ' . Yii::$app->name)
            ->send();
    }

}
