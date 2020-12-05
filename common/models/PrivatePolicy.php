<?php

namespace common\models;

use yii\base\Model;

/**
 * Class PrivatePolicy
 * @package backend\models
 * @property string $text
 */
class PrivatePolicy extends Model
{
    public $text;
    protected static $fileName = 'privatePolicy';

    public function rules()
    {
        return [
            [
                [
                    'text',
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
            'text' => 'Текст политики конфедециальности',
        ];
    }


    public function save($request = null){
        if ($request){
            $tempParams = json_encode($request);
        }else{
            $tempParams = json_encode($this->attributes);
        }
        $setPath = dirname(dirname(__DIR__)).'/common/config/json_params/'. self::$fileName .'.json';
        if (file_put_contents($setPath , $tempParams)){
            return true;
        };
        return false;
    }
}