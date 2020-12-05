<?php

namespace common\models;

use common\behaviors\ImgUploadBehavior;
use Yii;

/**
 * This is the model class for table "service".
 *
 * @property int $id
 * @property string $title
 * @property string $image
 * @property string $description
 * @property int $publish
 * @property int $rank
 * @property int $type
 *
 * @property ServiceItem[] $serviceItems
 */
class Service extends \yii\db\ActiveRecord
{
    const TYPE_NOTHING = 0;
    const TYPE_NAME = 1;
    const TYPE_CANDIE = 2;
    const TYPE_MOLEBEN = 3;
    const TYPE_TWO_BUTTONS = 4;

    const TXT_DONATE = 'Пожертвовать';
    const TXT_FO_HEALTH = 'О здравии';
    const TXT_FO_REPOSE = 'Об упокоении';


    protected static $typeToForm = [
        self::TYPE_NOTHING => 'Без типа',
        self::TYPE_NAME => 'Кнопка пожертвовать с указанием имени',
        self::TYPE_CANDIE => 'Свечи',
        self::TYPE_MOLEBEN => 'Молебны',
        self::TYPE_TWO_BUTTONS => 'Две кнопки "О здравии" и "Об упокоении" с выбором имени',
    ];


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service';
    }

    /**
     * @return array
     */
    public static function getTypeToForm()
    {
        return self::$typeToForm;
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'ImgUploadBehavior' => [
                'class' => ImgUploadBehavior::className(),
                'noImage' => 'no_image.png',
                'folder' => '/uploads/images/service_image',
                'propImage' => 'image',
            ],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['publish', 'rank', 'type'], 'integer'],
            [['title', 'image'], 'string', 'max' => 255],
            ['type', 'default', 'value' => self::TYPE_NOTHING],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'image' => 'Изображение',
            'description' => 'Описание',
            'publish' => 'Опубликовать',
            'rank' => 'Ранг',
            'type' => 'Тип',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceItems()
    {
        return $this->hasMany(ServiceItem::className(), ['service_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ServiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ServiceQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if (!$this->rank){
            $this->rank = 100;
        }
        return parent::beforeSave($insert);
    }

}
