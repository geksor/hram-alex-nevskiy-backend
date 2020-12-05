<?php

namespace common\models;

use common\behaviors\ImgUploadBehavior;
use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string $short_text
 * @property string $image
 * @property int $created_at
 * @property int $publish_at
 * @property int $publish
 * @property string $pubDateToForm
 *
 * @property EventForHome $eventForHome
 */
class News extends \yii\db\ActiveRecord
{
    public $pubDateToForm;
    const EVENT_TYPE = 1;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function afterFind()
    {
        parent::afterFind();

        $this->pubDateToForm = Yii::$app->formatter->asDate($this->publish_at, 'dd-MM-yyyy');
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
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
                'folder' => '/uploads/images/news_image',
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
            [['title', 'text'], 'required'],
            [['text'], 'string'],
            [['pubDateToForm'], 'string'],
            [['created_at', 'publish_at', 'publish'], 'integer'],
            [['title', 'image'], 'string', 'max' => 255],
            [['short_text'], 'string', 'max' => 128],
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
            'text' => 'Текст',
            'short_text' => 'Краткое описание',
            'image' => 'Изображение',
            'created_at' => 'Дата создания',
            'publish_at' => 'Дата публикации',
            'pubDateToForm' => 'Дата публикации',
            'publish' => 'Опубликовать',

        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\NewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\NewsQuery(get_called_class());
    }

    /**
     * @return EventForHome|null
     */
    public function getEventForHome()
    {
        return EventForHome::findOne(['event_id' => $this->id, 'event_type' => self::EVENT_TYPE]);
    }


    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {

        if (!$this->created_at){
            $this->created_at = Yii::$app->formatter->asTimestamp('today');
        }

        if ($this->pubDateToForm){

            $this->publish_at =
                is_string($this->pubDateToForm)
                    ? Yii::$app->formatter->asTimestamp($this->pubDateToForm)
                    : $this->publish_at;

        } elseif (!$this->publish_at) {

            $this->publish_at = Yii::$app->formatter->asTimestamp('today');

        }

        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes)
    {

        if (!$event = EventForHome::find()->fromId($this->id, self::EVENT_TYPE)->one()){
            $newEvent = new EventForHome([
                'event_id' => $this->id,
                'event_type' => self::EVENT_TYPE,
                'publish_at' => $this->publish_at,
                'publish' => $this->publish,
            ]);
            $newEvent->save();
        } else {
            $event->publish_at = $this->publish_at;
            $event->publish = $this->publish;
            $event->save();
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        $this->eventForHome->delete();
        return true;
    }

}
