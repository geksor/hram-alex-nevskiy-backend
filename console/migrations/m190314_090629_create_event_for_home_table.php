<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%event_for_home}}`.
 */
class m190314_090629_create_event_for_home_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%event_for_home}}', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer()->notNull(),
            'event_type' => $this->integer(1)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%event_for_home}}');
    }
}
