<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%service_item}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%service}}`
 */
class m190314_092058_create_service_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service_item}}', [
            'id' => $this->primaryKey(),
            'service_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'publish' => $this->integer(1)->notNull()->defaultValue(0),
            'rank' => $this->integer(),
        ]);

        // creates index for column `service_id`
        $this->createIndex(
            '{{%idx-service_item-service_id}}',
            '{{%service_item}}',
            'service_id'
        );

        // add foreign key for table `{{%service}}`
        $this->addForeignKey(
            '{{%fk-service_item-service_id}}',
            '{{%service_item}}',
            'service_id',
            '{{%service}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%service}}`
        $this->dropForeignKey(
            '{{%fk-service_item-service_id}}',
            '{{%service_item}}'
        );

        // drops index for column `service_id`
        $this->dropIndex(
            '{{%idx-service_item-service_id}}',
            '{{%service_item}}'
        );

        $this->dropTable('{{%service_item}}');
    }
}
