<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%chat}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%profile}}`
 */
class m190603_125718_create_chat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%chat}}', [
            'id' => $this->primaryKey(),
            'profile_id' => $this->integer()->notNull(),
            'text' => $this->string(),
            'date' => $this->integer(),
            'type' => $this->integer(1),
            'sended' => $this->integer(1)
        ]);

        // creates index for column `profile_id`
        $this->createIndex(
            '{{%idx-chat-profile_id}}',
            '{{%chat}}',
            'profile_id'
        );

        // add foreign key for table `{{%profile}}`
        $this->addForeignKey(
            '{{%fk-chat-profile_id}}',
            '{{%chat}}',
            'profile_id',
            '{{%profile}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%profile}}`
        $this->dropForeignKey(
            '{{%fk-chat-profile_id}}',
            '{{%chat}}'
        );

        // drops index for column `profile_id`
        $this->dropIndex(
            '{{%idx-chat-profile_id}}',
            '{{%chat}}'
        );

        $this->dropTable('{{%chat}}');
    }
}
