<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tokens}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m190314_083041_create_tokens_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tokens}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'token' => $this->string(255)->notNull()->unique(),
            'expired_at' => $this->integer()->notNull(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-tokens-user_id}}',
            '{{%tokens}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-tokens-user_id}}',
            '{{%tokens}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-tokens-user_id}}',
            '{{%tokens}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-tokens-user_id}}',
            '{{%tokens}}'
        );

        $this->dropTable('{{%tokens}}');
    }
}
