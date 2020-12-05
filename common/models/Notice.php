<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "notice".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property int $send_time
 */
class Notice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['send_time'], 'integer'],
            [['title', 'text'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'text' => 'Text',
            'send_time' => 'Send Time',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\NoticeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\NoticeQuery(get_called_class());
    }
}
