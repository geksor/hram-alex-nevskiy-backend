<?php
namespace frontend\widgets;

use common\models\CatalogSections;
use yii\base\Widget;

class HomeProductWidget extends Widget
{
    public function run()
    {
        $firstProduct = CatalogSections::find()->where(['show_on_home' => 1, 'publish' => 1])->one();
        $secondProduct = CatalogSections::find()->where(['show_on_home' => 2, 'publish' => 1])->one();
        $lastProduct = CatalogSections::find()->where(['show_on_home' => 3, 'publish' => 1])->one();

        return $this->render('homeProduct-widget', [
            'firstProduct' => $firstProduct,
            'secondProduct' => $secondProduct,
            'lastProduct' => $lastProduct,
        ]);
    }
}