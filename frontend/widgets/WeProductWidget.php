<?php
namespace frontend\widgets;

use common\models\Product;
use yii\base\Widget;

class WeProductWidget extends Widget
{
    public function run()
    {
        $models = Product::find()
            ->where(['publish' => 1, 'show_on_home' => 1])
            ->with(['props' => function (\yii\db\ActiveQuery $query) {
                        $query
                            ->andWhere(['show_on_list' => 1, 'publish' => 1])
                            ->orderBy(['rank' => SORT_ASC]);
                    },
                ])
            ->orderBy(['rank' => SORT_ASC])
            ->all();

        return $this->render('weProduct-widget', [
            'models' => $models,
        ]);
    }
}