<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders_app}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m190711_142425_create_orders_app_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders_app}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'name' => $this->string(),
            'service_name' => $this->string(),
            'service_action' => $this->string(),
            'icon_saint' => $this->string(),
            'amount' => $this->integer(),
            'processed' => $this->integer(1)->defaultValue(0),
            'created_at' => $this->integer(),
            'viewed' => $this->integer(1)->defaultValue(0),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-orders_app-user_id}}',
            '{{%orders_app}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-orders_app-user_id}}',
            '{{%orders_app}}',
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
            '{{%fk-orders_app-user_id}}',
            '{{%orders_app}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-orders_app-user_id}}',
            '{{%orders_app}}'
        );

        $this->dropTable('{{%orders_app}}');
    }
}
