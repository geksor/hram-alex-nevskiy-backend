<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%votes_users_count}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%votes}}`
 * - `{{%user}}`
 */
class m190314_084457_create_junction_table_for_votes_and_user_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%votes_users_count}}', [
            'votes_id' => $this->integer(),
            'user_id' => $this->integer(),
            'PRIMARY KEY(votes_id, user_id)',
        ]);

        // creates index for column `votes_id`
        $this->createIndex(
            '{{%idx-votes_users_count-votes_id}}',
            '{{%votes_users_count}}',
            'votes_id'
        );

        // add foreign key for table `{{%votes}}`
        $this->addForeignKey(
            '{{%fk-votes_users_count-votes_id}}',
            '{{%votes_users_count}}',
            'votes_id',
            '{{%votes}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-votes_users_count-user_id}}',
            '{{%votes_users_count}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-votes_users_count-user_id}}',
            '{{%votes_users_count}}',
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
        // drops foreign key for table `{{%votes}}`
        $this->dropForeignKey(
            '{{%fk-votes_users_count-votes_id}}',
            '{{%votes_users_count}}'
        );

        // drops index for column `votes_id`
        $this->dropIndex(
            '{{%idx-votes_users_count-votes_id}}',
            '{{%votes_users_count}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-votes_users_count-user_id}}',
            '{{%votes_users_count}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-votes_users_count-user_id}}',
            '{{%votes_users_count}}'
        );

        $this->dropTable('{{%votes_users_count}}');
    }
}
