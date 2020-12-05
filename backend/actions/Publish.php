<?php
/**
 * Created by PhpStorm.
 * User: Geksor
 * Date: 28.03.2019
 * Time: 11:37
 */

namespace backend\actions;


use Yii;
use yii\base\Action;

/**
 * Class Publish
 *
 * Parent Class method findModel change protected -> public
 *
 * From GreedView:
 * ```php
 * [
 *   'attribute' => 'publish',
 *   'filter'=>[0=>"Не опубликованные",1=>"Опубликованные"],
 *   'filterInputOptions' => ['prompt' => 'Все', 'class' => 'form-control form-control-sm'],
 *   'headerOptions' => ['width' => 100],
 *   'format' => 'raw',
 *   'value' => function ($data) {
 *      // here insert comment to $data
 *      $urlPublish = Url::to(['publish']);
 *      return SwitchInput::widget([
 *          'name' => "publish_$data->id",
 *          'value' => $data->publish,
 *          'class' => 'col-center',
 *          'pluginOptions' => [
 *              'onColor' => 'success',
 *              'offColor' => 'danger',
 *              'onText' => '<i class="glyphicon glyphicon-ok"></i>',
 *              'offText' => '<i class="glyphicon glyphicon-remove"></i>',
 *          ],
 *          'options' => [
 *              'data-id' => $data->id,
 *          ],
 *          'pluginEvents' => [
 *              'switchChange.bootstrapSwitch' => "function() {
 *                                                         $.ajax({
 *                                                         type: 'GET',
 *                                                         url: '$urlPublish',
 *                                                         data: 'id='+ $(this).data('id') + '&publish=' + Number($(this).prop('checked')),
 *                                                     }) }"
 *          ]
 *      ]);
 *   }
 * ],
 * ```
 *
 * @package backend\actions
 */

class Publish extends Action
{

    /**
     * @param $id
     * @param $publish
     * @return mixed
     */
    public function run($id, $publish)
    {
        if (Yii::$app->request->isAjax && $id){

            $model = $this->controller->findModel($id);

            $model->publish = (integer) $publish;

            if ($model->save(false)){
                return 'success';
            }

            Yii::$app->session->setFlash('error', 'Что то пошло не так');
            return $this->controller->redirect(Yii::$app->request->referrer);

        }

        if ($id){
            $model = $this->controller->findModel($id);

            $model->publish = (integer) $publish;

            if ($model->save(false)){
                Yii::$app->session->setFlash('success', 'Успешно');
            } else {
                Yii::$app->session->setFlash('error', 'Что то пошло не так');
            }
        }

        return $this->controller->redirect(Yii::$app->request->referrer);
    }


}
