<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "clergy_question".
 *
 * @property int $id
 * @property int $user_id
 * @property string $text
 * @property int $created_at
 * @property int $done_at
 * @property int $view
 *
 * @property User $user
 */
class ClergyQuestion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clergy_question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'text', 'created_at'], 'required'],
            [['user_id', 'created_at', 'done_at', 'view'], 'integer'],
            [['text'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID Пользователя',
            'text' => 'Текст',
            'created_at' => 'Дата создания',
            'done_at' => 'Дата исполнения',
            'view' => 'Просмотрена',
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
     * {@inheritdoc}
     * @return \common\models\query\ClergyQuestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ClergyQuestionQuery(get_called_class());
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($this->created_at){

            $this->created_at =
                is_string($this->created_at)
                    ? strtotime($this->created_at)
                    : $this->created_at;
        }else{
            $this->created_at = time();
        }
        return parent::beforeSave($insert);
    }

}
