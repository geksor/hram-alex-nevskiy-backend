<?php
namespace api\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\db\Query;

/**
 * Signup form
 *
 * @property string $email
 * @property string $password
 * @property string $confirmPassword
 * @property string $name
 *
 */
class SignupForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $confirmPassword;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Данный e-mail уже используется.'],

            ['name', 'required'],
            ['name', 'trim'],
            ['name', 'string', 'max' => 255],

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
            'username' => 'Имя пользователя',
            'email' => 'E-mail',
            'password' => 'Пароль',
            'confirmPassword' => 'Подтверждение пароля',
        ];
    }


    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     * @throws \yii\base\Exception
     * @throws \Exception
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->email;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateConfirmCode();
        if ($this->sendEmail($user) && $user->save()){
            $user->profile->name = $this->name;
            $user->profile->email = $this->email;
            return $user->profile->save();
        };
        return false;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'codeVerify-html', 'text' => 'codeVerify-text'],
                ['user' => $user, 'password' => $this->password]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Регистрация аккаунта для ' . Yii::$app->name)
            ->send();
    }

    public function fields()
    {
        return [
            'email',
        ];
    }
}
