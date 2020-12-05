<?php

namespace api\models;

use common\models\User;
use phpDocumentor\Reflection\Types\Integer;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use yii\web\ForbiddenHttpException;

class VerifyConfirmCode extends Model
{
    /**
     * @var int
     */
    public $code;
    /**
     * @var string
     */
    public $username;

    /**
     * @var User
     */
    private $_user;


    /**
     * Creates a form model with given code.
     *
     * @param string $code
     * @param string $username
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws ForbiddenHttpException
     */
    public function __construct($code, $username, array $config = [])
    {
        if (empty($code) || !is_string($code) || empty($username) || !is_string($username)) {
            throw new InvalidArgumentException('Код подтверждения не может быть пустым.');
        }
        $this->_user = User::findByConfirmCode($code, $username);
        if (!$this->_user) {
            throw new ForbiddenHttpException('Неверный код подтверждения.');
        }
        parent::__construct($config);
    }

    /**
     * Verify code
     *
     * @return User|null the saved model or null if saving fails
     */
    public function verifyCode()
    {
        $user = $this->_user;
        $user->status = User::STATUS_ACTIVE;
        $user->confirm_code = null;
        return $user->save(false) ? $user : null;
    }

}
