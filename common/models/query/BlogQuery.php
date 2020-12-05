<?php

namespace common\models\query;

use Yii;

/**
 * This is the ActiveQuery class for [[\common\models\Blog]].
 *
 * @see \common\models\Blog
 */
class BlogQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['publish' => 1])->andWhere(['<=', 'publish_at', Yii::$app->formatter->asTimestamp('today')]);
    }

    public function orderByPublish()
    {
        return $this->orderBy(['publish_at' => SORT_DESC, 'id' => SORT_DESC]);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Blog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Blog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
