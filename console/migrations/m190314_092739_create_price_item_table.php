<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%price_item}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%price}}`
 */
class m190314_092739_create_price_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%price_item}}', [
            'id' => $this->primaryKey(),
            'price_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'publish' => $this->integer(1)->notNull()->defaultValue(0),
            'rank' => $this->integer(),
        ]);

        // creates index for column `price_id`
        $this->createIndex(
            '{{%idx-price_item-price_id}}',
            '{{%price_item}}',
            'price_id'
        );

        // add foreign key for table `{{%price}}`
        $this->addForeignKey(
            '{{%fk-price_item-price_id}}',
            '{{%price_item}}',
            'price_id',
            '{{%price}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%price}}`
        $this->dropForeignKey(
            '{{%fk-price_item-price_id}}',
            '{{%price_item}}'
        );

        // drops index for column `price_id`
        $this->dropIndex(
            '{{%idx-price_item-price_id}}',
            '{{%price_item}}'
        );

        $this->dropTable('{{%price_item}}');
    }
}
