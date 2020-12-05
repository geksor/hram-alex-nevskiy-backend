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
 * Class Rank
 *
 * Parent Class method findModel change protected -> public
 *
 * From GreedView:
 * ```php
 * [
 *      'attribute' => 'rank',
 *      'headerOptions' => ['width' => 130],
 *      'contentOptions'=>['style'=>'min-width: 130px;'],
 *      'format' => 'raw',
 *      'content' => function ($data){
 *          // here insert comment to $data
 *           return "<div class='input-group'>" . Html::activeInput('number', $data, 'rank', ['class' => 'form-control', 'data-id' => $data->id, 'id' => "rank_$data->id"]) .
 *             "<span class='input-group-btn'>" . Html::button('<span class="glyphicon glyphicon-ok"></span>', ['class'=>'btn btn-primary rankSuccess', 'data-input'=>"#rank_$data->id"]) . "</span></div>";
 *      }
 * ],
 * ```
 * Add JS code:
 * ```php
 * <?php
 *
 * $urlRank = Url::to(['rank']);
 * $js = <<< JS
 *      $('.rankSuccess').on('click', function(){
 *          var inputRank = $($(this).data('input'));
 *          var btn = $(this);
 *          $.ajax({
 *              type: "GET",
 *              url: "$urlRank",
 *              data: 'id='+ inputRank.data('id') +'&rank='+ inputRank.val(),
 *              success: function(data) {
 *                  if (data === 'success'){
 *                      btn.removeClass('btn-primary').addClass('btn-success').blur();
 *                      setTimeout(function() {
 *                          btn.removeClass('btn-success').addClass('btn-primary');
 *                      }, 5000)
 *                  } else {
 *                      btn.blur();
 *                  }
 *              }
 *          })
 *      });
 *
 * JS;
 *
 * $this->registerJs($js, $position = yii\web\View::POS_END, $key = null);
 *
 * ?>
 * ```
 *
 * @package backend\actions
 *
 */

class Rank extends Action
{

    /**
     * @param $id
     * @param $rank
     * @return mixed
     */
    public function run($id, $rank)
    {
        if (Yii::$app->request->isAjax && $id){

            $model = $this->controller->findModel($id);

            if ($model){

                if ($model->rank === (integer)$rank){
                    return 'no_change';
                }

                $model->rank = (integer) $rank;

                if ($model->save(false)){
                    return 'success';
                }

                Yii::$app->session->setFlash('error', 'Что то пошло не так');

                return $this->controller->redirect(Yii::$app->request->referrer);
            }
        }
        return $this->controller->redirect(Yii::$app->request->referrer);
    }

}