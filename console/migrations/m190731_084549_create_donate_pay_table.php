<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%donate_pay}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%donate}}`
 */
class m190731_084549_create_donate_pay_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%donate_pay}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'donate_id' => $this->integer()->notNull(),
            'amount' => $this->integer(),
            'status' => $this->integer(),
            'pay_id' => $this->string(),
            'created_at' => $this->integer(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-donate_pay-user_id}}',
            '{{%donate_pay}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-donate_pay-user_id}}',
            '{{%donate_pay}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `donate_id`
        $this->createIndex(
            '{{%idx-donate_pay-donate_id}}',
            '{{%donate_pay}}',
            'donate_id'
        );

        // add foreign key for table `{{%donate}}`
        $this->addForeignKey(
            '{{%fk-donate_pay-donate_id}}',
            '{{%donate_pay}}',
            'donate_id',
            '{{%donate}}',
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
            '{{%fk-donate_pay-user_id}}',
            '{{%donate_pay}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-donate_pay-user_id}}',
            '{{%donate_pay}}'
        );

        // drops foreign key for table `{{%donate}}`
        $this->dropForeignKey(
            '{{%fk-donate_pay-donate_id}}',
            '{{%donate_pay}}'
        );

        // drops index for column `donate_id`
        $this->dropIndex(
            '{{%idx-donate_pay-donate_id}}',
            '{{%donate_pay}}'
        );

        $this->dropTable('{{%donate_pay}}');
    }
}
