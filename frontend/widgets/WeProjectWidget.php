<?php
namespace frontend\widgets;

use common\models\CatalogSections;
use common\models\Project;
use yii\base\Widget;

class WeProjectWidget extends Widget
{
    public function run()
    {
        $models = Project::find()->where(['publish' => 1])->orderBy(['rank' => SORT_ASC])->all();

        return $this->render('weProject-widget', [
            'models' => $models,
        ]);
    }
}