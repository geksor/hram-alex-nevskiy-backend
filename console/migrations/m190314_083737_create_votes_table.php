<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%votes}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m190314_083737_create_votes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%votes}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'user_name' => $this->string(),
            'title' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'type' => $this->integer(1),
            'publish' => $this->integer(1)->notNull()->defaultValue(0),
            'publish_at' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'view' => $this->integer(1),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-votes-user_id}}',
            '{{%votes}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-votes-user_id}}',
            '{{%votes}}',
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
            '{{%fk-votes-user_id}}',
            '{{%votes}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-votes-user_id}}',
            '{{%votes}}'
        );

        $this->dropTable('{{%votes}}');
    }
}
