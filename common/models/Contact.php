<?php

namespace common\models;

use common\behaviors\ImgUploadBehavior;
use yii\base\Model;

/**
 * Class Contact
 * @package backend\models
 *
 * @property string $title
 * @property string $timetable
 * @property string $phone
 * @property string $phoneWithText
 * @property string $address
 * @property string $index
 * @property string $email
 * @property string $image
 *
 * @property int $chatId
 * @property string $replacePhone
 */
class Contact extends Model
{
    public $title;
    public $timetable;
    public $phone;
    public $phoneWithText;
    public $address;
    public $index;
    public $email;
    public $image;

    public $chatId;

    public function rules()
    {
        return [
            [
                [
                    'title',
                    'timetable',
                    'phoneWithText',
                    'address',
                    'index',
                    'email',
                    'image',

                    'chatId',
                ],
                'safe'
            ],
            ['phone', 'match', 'pattern' => '/^([+]?[0-9\s-\(\)]{6,25})*$/i']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'timetable' => 'Расписание',
            'phone' => 'Телефон для кнопки позвонить (только один номер телефона без текста)',
            'phoneWithText' => 'Телефон для вывода в разделе контакты (свободная форма)',
            'address' => 'Адрес',
            'index' => 'Индекс',
            'email' => 'E-mail',
            'image' => 'Изображение',

            'chatId' => 'ID чата',
        ];
    }


    public function behaviors()
    {
        return [
            'ImgUploadBehavior' => [
                'class' => ImgUploadBehavior::className(),
                'noImage' => 'no_image.png',
                'folder' => '/uploads/images/pages_img',
                'propImage' => 'image'
            ],
        ];
    }

    public function getReplacePhone($phone)
    {
        return preg_replace("/[^0-9]/", '', $phone);
    }

    public function save($request = null){
        if ($request){
            $tempParams = json_encode($request);
        }else{
            $tempParams = json_encode($this->attributes);
        }
        $setPath = dirname(dirname(__DIR__)).'/common/config/json_params/contact.json';
        if (file_put_contents($setPath , $tempParams)){
            return true;
        };
        return false;
    }
}