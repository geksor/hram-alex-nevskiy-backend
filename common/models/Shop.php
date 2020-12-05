<?php

namespace common\models;

use common\behaviors\ImgUploadBehavior;
use yii\base\Model;

/**
 * Class Shop
 * @package backend\models
 *
 * @property string $title
 * @property string $text
 * @property string $timetable
 * @property string $phone
 * @property string $image
 * @property integer $gallery_id
 */
class Shop extends Model
{
    public $title;
    public $text;
    public $timetable;
    public $phone;
    public $image;
    public $gallery_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'title',
                    'text',
                    'timetable',
                    'phone',
                    'image',
                    'gallery_id',
                ],
                'safe'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'text' => 'Текст',
            'timetable' => 'Расписание',
            'phone' => 'Номер телефона',
            'image' => 'Изображение',
            'gallery_id' => 'ID галлереи',
        ];
    }

    /**
     * {@inheritdoc}
     */
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


    /**
     * @param $request
     * @return bool
     */
    public function save($request = null){
        if ($request){
            $tempParams = json_encode($request);
        }else{
            $tempParams = json_encode($this->attributes);
        }
        $setPath = dirname(dirname(__DIR__)).'/common/config/json_params/shop.json';
        if (file_put_contents($setPath , $tempParams)){
            return true;
        };
        return false;
    }
}