<?php
namespace backend\widgets;

use common\models\Chat;
use yii\base\Widget;

class NewMessageWidget extends Widget
{
    public function run()
    {
        $models = Chat::find()->noViewedBackend()->all();

        return $this->render('new-message', [
            'models' => $models,
        ]);
    }
}