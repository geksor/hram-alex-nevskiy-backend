<?php
namespace api\models;

use common\models\Tokens;
use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class PasswordForm extends Model
{
    public $password;
    public $new_password;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['new_password', 'password'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['new_password', 'string', 'min' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'new_password' => 'Новый пароль',
            'password' => 'Старый пароль',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неверный старый пароль.');
            }
        }
    }

    /**
     * @return null |null
     * @throws \yii\base\Exception
     */
    public function updatePassword()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            if (isset($user)) {
                $user->setPassword($this->new_password);
                if ($user->save()){
                    Tokens::deleteAll(['user_id' => $user->id]);
                    return ['username' => $user->username];
                };
            }
        }
        return null;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findOne(['id' => Yii::$app->user->id]);
        }

        return $this->_user;
    }
}
