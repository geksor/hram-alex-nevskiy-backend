<?
/* @var $model \common\models\Callback
 * @var $contact \common\models\Contact
 */

use yii\bootstrap\ActiveForm;

?>

<div class="main__questions">
    <div class="container-fluid main__questions-background-image">
        <div class="container">
            <h2 class="main__question-title-text">Если у Вас возникли вопросы, вы всегда можете нам написать</h2>
                <? $form = ActiveForm::begin([
                    'action' => '/site/call-back',
                    'options' => [
                        'class' => 'row main__questions-wrapper'
                    ]
                ]) ?>
                    <div style="display: none">
                        <?= $form->field($model, 'first_name')->label(false) ?>
                    </div>


                    <div class="col-lg-12 main__questions-wrapper">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <?= $form->field($model, 'name')->textInput(['class' => 'main__questions-name', 'placeholder' => 'Ваше имя'])->label(false) ?>
                            </div>
                            <div class="col-12 col-md-6">
                                <?= $form->field($model, 'email')->textInput(['class' => 'main__questions-eamil', 'placeholder' => 'E-mail адрес'])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <div class="main__questions-wrapper">

                        <?= $form->field($model, 'text')
                            ->textarea([
                                'class' => 'main__questions-textarea',
                                'placeholder' => 'Текст сообщения...',
                                'rows' => 10,
                                'cols' => 30,
                            ])
                            ->label(false) ?>

                        <div class="main__question-agree-wrapper">
                            <p class="main__questions-text">
                                Нажимая кнопку отправить вы соглашаетесь с
                                <a href="/personal-information">
                                    обработкой персональных данных
                                </a>
                            </p>
                        </div>

                        <button class="main__question-button-send">Отправить</button>
                    </div>

                <? ActiveForm::end() ?>
        </div>
    </div>
</div>
