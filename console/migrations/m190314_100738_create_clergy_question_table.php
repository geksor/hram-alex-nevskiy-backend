<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clergy_question}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%clergy}}`
 * - `{{%user}}`
 */
class m190314_100738_create_clergy_question_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clergy_question}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'text' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'done_at' => $this->integer(),
            'view' => $this->integer(1),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-clergy_question-user_id}}',
            '{{%clergy_question}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-clergy_question-user_id}}',
            '{{%clergy_question}}',
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
            '{{%fk-clergy_question-user_id}}',
            '{{%clergy_question}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-clergy_question-user_id}}',
            '{{%clergy_question}}'
        );

        $this->dropTable('{{%clergy_question}}');
    }
}
