<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property string $title
 * @property string $video_link
 * @property int $publish_at
 * @property int $created_at
 * @property int $publish
 * @property string $pubDateToForm
 *
 * @property EventForHome $eventForHome
 */
class Blog extends \yii\db\ActiveRecord
{
    public $pubDateToForm;
    const EVENT_TYPE = 2;

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
        return 'blog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'video_link'], 'required'],
            [['publish_at', 'created_at', 'publish'], 'integer'],
            [['pubDateToForm'], 'string'],
            [['title', 'video_link'], 'string', 'max' => 255],
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
            'video_link' => 'Ссылка на видео',
            'publish_at' => 'Дата публикации',
            'created_at' => 'Дата создания',
            'publish' => 'Опубликовать',
            'pubDateToForm' => 'Дата публикации'
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\BlogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\BlogQuery(get_called_class());
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

        }else{

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
                'publish' => $this->publish
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
