<?php
namespace frontend\widgets;

use common\models\Category;
use yii\base\Widget;

class CategoryWidget extends Widget
{
    public function run()
    {
        $models = Category::find()
            ->where(['publish' => 1, 'parent_id' => null])
            ->orderBy(['rank' => SORT_ASC])
            ->all();

        return $this->render('category-widget', [
            'models' => $models,
        ]);
    }
}