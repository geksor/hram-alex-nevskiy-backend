<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%calendar_events}}`.
 */
class m190314_093539_create_calendar_events_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%calendar_events}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'text' => $this->text(),
            'start_day' => $this->integer(),
            'stop_day' => $this->integer(),
            'color' => $this->string(),
            'publish' => $this->integer(1)->notNull()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%calendar_events}}');
    }
}
