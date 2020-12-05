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
 */
class BlogSecond extends \yii\db\ActiveRecord
{
    public $pubDateToForm;

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
        return 'blog_second';
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
     * @return \common\models\query\BlogSecondQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\BlogSecondQuery(get_called_class());
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

}
