<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 *
 * Property first_name trap from bot
 *
 * @property string $name
 * @property string $phone
 * @property string $body
 * @property string $first_name
 *
 */
class ContactForm extends Model
{
    public $name;
    public $phone;
    public $body;
    public $first_name;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, phone and body are required
            [['name', 'phone', 'body'], 'required'],
            // phone has to be a valid pattern
            ['phone', 'match', 'pattern' => '/^([+]?[0-9\s-\(\)]{6,25})*$/i'],
            // first_name needs to be null
            ['first_name', 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
            'phone' => 'Номер телефона',
            'body' => 'Текст сообщения',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($setTo)
    {
        $mailHead = 'Письмо со страницы "О нас"';
        $body = '<h1>'.$mailHead.'</h1>
                <p>'.$this->body.'</p>
                <h2>Информация об отправителе</h2>
                <p> Имя: '.$this->name.'</p>
                <p> Телефон: '.$this->phone . '</p>';

        return Yii::$app->mailer->compose()
            ->setTo($setTo)
            ->setFrom([Yii::$app->params['notificEmail'] => Yii::$app->name])
            ->setSubject($mailHead.' от '. $this->name)
            ->setHtmlBody($body)
            ->send();
    }
}
