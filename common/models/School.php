<?php

namespace common\models;

use common\behaviors\ImgUploadBehavior;
use yii\base\Model;

/**
 * Class School
 * @package backend\models
 *
 * @property string $title
 * @property string $text
 * @property string $timetable
 * @property string $image
 * @property integer $phone
 * @property integer $gallery_id
 */
class School extends Model
{
    public $title;
    public $text;
    public $timetable;
    public $image;
    public $phone;
    public $gallery_id;

    public function rules()
    {
        return [
            [
                [
                    'title',
                    'text',
                    'timetable',
                    'image',
                    'phone',
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
            'image' => 'Изображение',
            'phone' => 'Телефон',
            'gallery_id' => 'ID галлереи',
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



    public function save($request = null){
        if ($request){
            $tempParams = json_encode($request);
        }else{
            $tempParams = json_encode($this->attributes);
        }
        $setPath = dirname(dirname(__DIR__)).'/common/config/json_params/school.json';
        if (file_put_contents($setPath , $tempParams)){
            return true;
        };
        return false;
    }
}