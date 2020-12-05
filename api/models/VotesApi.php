<?php

namespace api\models;

use common\models\User;
use common\models\Votes;
use common\models\VotesUsersCount;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * Class VotesApi
 * @package api\models
 *
 * @property int $userVoted
 */
class VotesApi extends Votes
{

	public function getUserVoted()
	{
		return VotesUsersCount::findOne(['user_id' => Yii::$app->user->id, 'votes_id' => $this->id]) ? 1 : 0;
	}

	/**
	 * @param $id - Votes ID
	 * @return array
	 * @throws NotFoundHttpException
	 * @throws StaleObjectException
	 * @throws Throwable
	 */
	public static function linkVotes($id): array
	{
		if (($model = self::findOne($id)) !== null) {
			$user = User::findOne(['id' => Yii::$app->user->id]);
			if (!empty($user)) {
				if ($user->getVotesSelfById($id)){
					return ['message' => 'user already voted'];
				}
			}
			$model->link('users', $user);
			++$model->votesCount;
			$model->update(false);
			return ['message' => 'success link'];
		}
		throw new NotFoundHttpException();
	}

	/**
	 * @param $id - Votes ID
	 * @return array
	 * @throws NotFoundHttpException
	 * @throws Throwable
	 * @throws StaleObjectException
	 */
	public static function unlinkVotes($id): array
	{
		VotesUsersCount::deleteAll(['votes_id' => $id, 'user_id' => Yii::$app->user->id]);

		if (($model = self::findOne($id)) !== null) {
			if ($model->votesCount >= 1) {
				--$model->votesCount;
			}
			$model->update(false);

			return ['message' => 'success unlink'];
		}
		throw new NotFoundHttpException();
	}

	public function fields()
	{
		return [
			'id',
			'user_name',
			'title',
			'text',
			'type' => function () {
				return $this->typeName[$this->type];
			},
			'publish_at' => function () {
				return 'Опубликовано ' . Yii::$app->formatter->asDate($this->publish_at, 'long');
			},
			'votesCount',
			'userVoted',
		];
	}
}
