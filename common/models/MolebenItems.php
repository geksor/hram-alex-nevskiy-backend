<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "moleben_items".
 *
 * @property int $id
 * @property string $title
 * @property int $rank
 * @property int $publish
 */
class MolebenItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'moleben_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rank', 'publish'], 'integer'],
            [['title'], 'string', 'max' => 255],
            ['rank', 'default', 'value' => 100],
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
            'rank' => 'Порядок вывода',
            'publish' => 'Публикация',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\MolebenItemsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\MolebenItemsQuery(get_called_class());
    }
}
