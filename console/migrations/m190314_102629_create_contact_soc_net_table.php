<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contact_soc_net}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%soc_net}}`
 */
class m190314_102629_create_contact_soc_net_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contact_soc_net}}', [
            'id' => $this->primaryKey(),
            'soc_net_id' => $this->integer()->notNull(),
            'link' => $this->string()->notNull(),
            'publish' => $this->integer(1)->notNull()->defaultValue(0),
            'rank' => $this->integer(),
        ]);

        // creates index for column `soc_net_id`
        $this->createIndex(
            '{{%idx-contact_soc_net-soc_net_id}}',
            '{{%contact_soc_net}}',
            'soc_net_id'
        );

        // add foreign key for table `{{%soc_net}}`
        $this->addForeignKey(
            '{{%fk-contact_soc_net-soc_net_id}}',
            '{{%contact_soc_net}}',
            'soc_net_id',
            '{{%soc_net}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%soc_net}}`
        $this->dropForeignKey(
            '{{%fk-contact_soc_net-soc_net_id}}',
            '{{%contact_soc_net}}'
        );

        // drops index for column `soc_net_id`
        $this->dropIndex(
            '{{%idx-contact_soc_net-soc_net_id}}',
            '{{%contact_soc_net}}'
        );

        $this->dropTable('{{%contact_soc_net}}');
    }
}
