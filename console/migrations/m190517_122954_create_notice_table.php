<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%notice}}`.
 */
class m190517_122954_create_notice_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%notice}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'text' => $this->string(),
            'send_time' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%notice}}');
    }
}
