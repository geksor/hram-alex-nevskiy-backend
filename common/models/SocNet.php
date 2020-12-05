<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "soc_net".
 *
 * @property int $id
 * @property string $title
 * @property string $pre_link
 * @property string $image_svg
 * @property string $description
 * @property int $publish
 * @property string $uploadImage
 *
 * @property ClergySocNet[] $clergySocNets
 * @property ContactSocNet[] $contactSocNets
 */
class SocNet extends \yii\db\ActiveRecord
{
    public $uploadImage;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'soc_net';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['image_svg', 'description'], 'string'],
//            [['publish'], 'integer'],
            [['title', 'pre_link'], 'string', 'max' => 255],
            [['uploadImage'], 'image', 'extensions' => ['svg']],
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
            'pre_link' => 'Ссылка',
            'image_svg' => 'Изображение',
            'description' => 'Описание',
//            'publish' => 'Publish',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClergySocNets()
    {
        return $this->hasMany(ClergySocNet::className(), ['soc_net_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContactSocNets()
    {
        return $this->hasMany(ContactSocNet::className(), ['soc_net_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\SocNetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SocNetQuery(get_called_class());
    }
}
