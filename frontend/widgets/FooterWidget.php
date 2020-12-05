<?php
namespace frontend\widgets;

use common\models\Contact;
use yii\base\Widget;

class FooterWidget extends Widget
{
    public function run()
    {
        $paramsContact = new Contact();
        $paramsContact->load(\Yii::$app->params);

        return $this->render('footer-widget', [
            'paramsContact' => $paramsContact,
        ]);
    }
}