<?php

use yii\db\Migration;

/**
 * Handles adding votesCount to table `{{%votes}}`.
 */
class m190417_104707_add_votesCount_column_to_votes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%votes}}', 'votesCount', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%votes}}', 'votesCount');
    }
}
