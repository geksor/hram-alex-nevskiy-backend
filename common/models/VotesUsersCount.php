<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "votes_users_count".
 *
 * @property int $votes_id
 * @property int $user_id
 *
 * @property User $user
 * @property Votes $votes
 */
class VotesUsersCount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'votes_users_count';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['votes_id', 'user_id'], 'required'],
            [['votes_id', 'user_id'], 'integer'],
            [['votes_id', 'user_id'], 'unique', 'targetAttribute' => ['votes_id', 'user_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['votes_id'], 'exist', 'skipOnError' => true, 'targetClass' => Votes::className(), 'targetAttribute' => ['votes_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'votes_id' => 'Votes ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotes()
    {
        return $this->hasOne(Votes::className(), ['id' => 'votes_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\VotesUsersCountQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\VotesUsersCountQuery(get_called_class());
    }
}
