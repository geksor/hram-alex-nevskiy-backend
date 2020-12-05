<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "useful_links".
 *
 * @property int $id
 * @property string $title
 * @property string $link
 * @property int $rank
 * @property int $publish
 */
class UsefulLinks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'useful_links';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'link'], 'required'],
            [['rank', 'publish'], 'integer'],
            [['title', 'link'], 'string', 'max' => 255],
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
            'link' => 'Ссылка',
            'rank' => 'Ранг',
            'publish' => 'Опубликовать',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\UsefulLinksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\UsefulLinksQuery(get_called_class());
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
