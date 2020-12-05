<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "clergy_soc_net".
 *
 * @property int $id
 * @property int $clergy_id
 * @property int $soc_net_id
 * @property string $link
 * @property int $publish
 * @property int $rank
 *
 * @property Clergy $clergy
 * @property SocNet $socNet
 *
 * @property array $socNetForList
 */
class ClergySocNet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clergy_soc_net';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clergy_id', 'soc_net_id'], 'required'],
            [['clergy_id', 'soc_net_id', 'publish', 'rank'], 'integer'],
            [['link'], 'string', 'max' => 255],
            [['clergy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clergy::className(), 'targetAttribute' => ['clergy_id' => 'id']],
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
            'clergy_id' => 'ID',
            'soc_net_id' => 'ID Соцсети',
            'link' => 'Ссылка',
            'publish' => 'Опубликовать',
            'rank' => 'Ранг',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClergy()
    {
        return $this->hasOne(Clergy::className(), ['id' => 'clergy_id']);
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
     * @return \common\models\query\ClergySocNetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ClergySocNetQuery(get_called_class());
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
