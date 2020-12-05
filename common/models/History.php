<?php

namespace common\models;

use common\behaviors\ImgUploadBehavior;
use yii\base\Model;

/**
 * Class History
 * @package backend\models
 *
 * @property string $title
 * @property string $text_header
 * @property string $text
 * @property string $image
 * @property integer $gallery_id
 */
class History extends Model
{
    public $title;
    public $text_header;
    public $text;
    public $image;
    public $gallery_id;

    public function rules()
    {
        return [
            [
                [
                    'title',
                    'text_header',
                    'text',
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
            'text_header' => 'Заголовот текста',
            'text' => 'Текст',
            'image' => 'Изображение',
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
        $setPath = dirname(dirname(__DIR__)).'/common/config/json_params/history.json';
        if (file_put_contents($setPath , $tempParams)){
            return true;
        };
        return false;
    }
}