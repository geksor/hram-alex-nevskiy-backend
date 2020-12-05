<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%chat_subscrib}}`.
 */
class m190606_131111_create_chat_subscrib_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%chat_subscrib}}', [
            'id' => $this->primaryKey(),
            'token' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%chat_subscrib}}');
    }
}
