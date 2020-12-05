<?php

namespace common\models;

use common\behaviors\ImgUploadBehavior;
use Yii;

/**
 * This is the model class for table "clergy".
 *
 * @property int $id
 * @property string $name
 * @property string $chin
 * @property string $position
 * @property int $birthday
 * @property int $name_day
 * @property int $jericho_ordination
 * @property int $deacon_ordination
 * @property string $education
 * @property string $service_places
 * @property string $rewards
 * @property string $photo
 * @property int $publish
 * @property int $abbot
 *
 * @property string $birthdayString
 * @property string $name_dayString
 * @property string $jericho_ordinationString
 * @property string $deacon_ordinationString
 *
 * @property ClergySocNet[] $clergySocNets
 * @property boolean $showAbbot
 */
class Clergy extends \yii\db\ActiveRecord
{
    public $birthdayString;
    public $name_dayString;
    public $jericho_ordinationString;
    public $deacon_ordinationString;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clergy';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'ImgUploadBehavior' => [
                'class' => ImgUploadBehavior::className(),
                'noImage' => 'no_image.png',
                'folder' => '/uploads/images/clergy_photo',
                'propImage' => 'photo',
            ],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['birthday', 'name_day', 'jericho_ordination', 'deacon_ordination', 'publish', 'abbot'], 'integer'],
            [['education', 'service_places', 'rewards'], 'string'],
            [['birthdayString', 'name_dayString', 'jericho_ordinationString', 'deacon_ordinationString'], 'string'],
            [['name', 'chin', 'position', 'photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'chin' => 'Чин',
            'position' => 'Должность',
            'birthday' => 'День рождения',
            'name_day' => 'День тезоименитства',
            'jericho_ordination' => 'Дата иерейской хиротонии',
            'deacon_ordination' => 'Дата диаконской хиротонии',
            'birthdayString' => 'День рождения',
            'name_dayString' => 'День тезоименитства',
            'jericho_ordinationString' => 'Дата иерейской хиротонии',
            'deacon_ordinationString' => 'Дата диаконской хиротонии',
            'education' => 'Образование',
            'service_places' => 'Место служения',
            'rewards' => 'Награды',
            'photo' => 'Фото',
            'publish' => 'Опубликовать',
            'abbot' => 'Настоятель',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClergySocNets()
    {
        return $this->hasMany(ClergySocNet::className(), ['clergy_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ClergyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ClergyQuery(get_called_class());
    }

    public function getShowAbbot()
    {
        return (self::findOne(['abbot' => 1]) && !$this->abbot)?false:true;
    }

    static function getAbbot()
    {
        return self::findOne(['abbot' => 1])?:null;
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {

        if ($this->birthdayString) {

            $this->birthday =
                is_string($this->birthdayString)
                    ? Yii::$app->formatter->asTimestamp($this->birthdayString)
                    : $this->birthday;

        }

        if ($this->name_dayString) {

            $this->name_day =
                is_string($this->name_dayString)
                    ? Yii::$app->formatter->asTimestamp($this->name_dayString)
                    : $this->name_day;

        }

        if ($this->jericho_ordinationString) {

            $this->jericho_ordination =
                is_string($this->jericho_ordinationString)
                    ? Yii::$app->formatter->asTimestamp($this->jericho_ordinationString)
                    : $this->jericho_ordination;

        }

        if ($this->deacon_ordinationString) {

            $this->deacon_ordination =
                is_string($this->deacon_ordinationString)
                    ? Yii::$app->formatter->asTimestamp($this->deacon_ordinationString)
                    : $this->deacon_ordination;

        }

        return parent::beforeSave($insert);

    }

}
