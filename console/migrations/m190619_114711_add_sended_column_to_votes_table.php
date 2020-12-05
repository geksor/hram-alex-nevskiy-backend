<?php

use yii\db\Migration;

/**
 * Handles adding sended to table `{{%votes}}`.
 */
class m190619_114711_add_sended_column_to_votes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%votes}}', 'sended', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%votes}}', 'sended');
    }
}
