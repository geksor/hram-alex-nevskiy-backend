<?php

use yii\db\Migration;

/**
 * Handles adding viewed to table `{{%chat}}`.
 */
class m190619_142615_add_viewed_column_to_chat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%chat}}', 'viewed', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%chat}}', 'viewed');
    }
}
