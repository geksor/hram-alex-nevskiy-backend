<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "contact_soc_net".
 *
 * @property int $id
 * @property int $soc_net_id
 * @property string $link
 * @property int $publish
 * @property int $rank
 *
 * @property SocNet $socNet
 *
 * @property array $socNetForList
 */
class ContactSocNet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact_soc_net';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['soc_net_id', 'link'], 'required'],
            [['soc_net_id', 'publish', 'rank'], 'integer'],
            [['link'], 'string', 'max' => 255],
            [['soc_net_id'], 'exist', 'skipOnError' => true, 'targetClass' => SocNet::className(), 'targetAttribute' => ['soc_net_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'soc_net_id' => 'ID Соцсети',
            'link' => 'Ссылка',
            'publish' => 'Опубликовать',
            'rank' => 'Ранг',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocNet()
    {
        return $this->hasOne(SocNet::className(), ['id' => 'soc_net_id']);
    }

    /**
     * @return array
     */
    public function getSocNetForList()
    {
        return ArrayHelper::map(SocNet::find()->all(), 'id', 'title');
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ContactSocNetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ContactSocNetQuery(get_called_class());
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
