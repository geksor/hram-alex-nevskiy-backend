<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gallery_image".
 *
 * @property int $id
 * @property string $type
 * @property int $ownerId
 * @property int $rank
 * @property string $name
 * @property string $description
 * @property int $rating
 * @property int $voteCount
 */
class GalleryImage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gallery_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ownerId'], 'required'],
            [['ownerId', 'rank', 'rating', 'voteCount'], 'integer'],
            [['description'], 'string'],
            [['type', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'ownerId' => 'Owner ID',
            'rank' => 'Rank',
            'name' => 'Name',
            'description' => 'Description',
            'rating' => 'Rating',
            'voteCount' => 'Vote Count',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\GalleryImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\GalleryImageQuery(get_called_class());
    }
}
