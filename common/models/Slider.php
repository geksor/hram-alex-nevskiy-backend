<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "slider".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string $link
 * @property int $rank
 * @property int $publish
 * @property int $selectSection
 */
class Slider extends \yii\db\ActiveRecord
{
    const NO_SECTION = 1;
    const SERVICE = 2;
    const DONATE = 3;
    const VOTES = 4;

    protected static $sections = [
        self::NO_SECTION => ['link' => 'disable', 'title' => 'Информация'],
        self::SERVICE => ['link' => 'service', 'title' => 'Требы'],
        self::DONATE => ['link' => 'donate', 'title' => 'Сбор пожертвований'],
        self::VOTES => ['link' => 'votes', 'title' => 'Голосование'],
    ];

    protected static $sectionsToForm = [
        self::NO_SECTION => 'Информация',
        self::SERVICE => 'Требы',
        self::DONATE => 'Сбор пожертвований',
        self::VOTES => 'Голосование',
    ];

    protected static $selectSectionsArr = [
        'disable' => self::NO_SECTION,
        'service' => self::SERVICE,
        'donate' => self::DONATE,
        'votes' => self::VOTES,
    ];

    public $selectSection;

    public function afterFind()
    {
        parent::afterFind();

        $this->selectSection = self::getSelectSectionsArr($this->link);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'slider';
    }

    /**
     * @return array
     */
    public static function getSelectSectionsArr($key)
    {
        return self::$selectSectionsArr[$key];
    }

    /**
     * @param $key
     * @return array
     */
    public static function getSections($key)
    {
        return self::$sections[$key];
    }

    /**
     * @return array
     */
    public static function getSectionsToForm()
    {
        return self::$sectionsToForm;
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['selectSection', 'text'], 'required'],
            [['rank', 'publish', 'selectSection'], 'integer'],
            [['title', 'text', 'link'], 'string', 'max' => 100],
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
            'text' => 'Текст',
            'link' => 'Ссылка',
            'rank' => 'Порядок вывода',
            'publish' => 'Опубликовать',
            'selectSection' => 'Заголовок',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\SliderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SliderQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if (!$this->rank){
            $this->rank = 100;
        }

        if ($this->selectSection){
            $this->title = self::getSections($this->selectSection)['title'];
            $this->link = self::getSections($this->selectSection)['link'];
        }

        return parent::beforeSave($insert);
    }

}
