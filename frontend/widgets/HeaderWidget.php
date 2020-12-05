<?php
namespace frontend\widgets;

use common\models\Contact;
use yii\base\Widget;

class HeaderWidget extends Widget
{
    public function run()
    {
        $paramsContact = new Contact();
        $paramsContact->load(\Yii::$app->params);

        return $this->render('header-widget', [
            'paramsContact' => $paramsContact,
        ]);
    }
}