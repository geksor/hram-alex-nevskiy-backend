<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clergy_soc_net}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%clergy}}`
 * - `{{%soc_net}}`
 */
class m190314_101426_create_clergy_soc_net_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clergy_soc_net}}', [
            'id' => $this->primaryKey(),
            'clergy_id' => $this->integer()->notNull(),
            'soc_net_id' => $this->integer()->notNull(),
            'link' => $this->string(),
            'publish' => $this->integer(1)->notNull()->defaultValue(0),
            'rank' => $this->integer(),
        ]);

        // creates index for column `clergy_id`
        $this->createIndex(
            '{{%idx-clergy_soc_net-clergy_id}}',
            '{{%clergy_soc_net}}',
            'clergy_id'
        );

        // add foreign key for table `{{%clergy}}`
        $this->addForeignKey(
            '{{%fk-clergy_soc_net-clergy_id}}',
            '{{%clergy_soc_net}}',
            'clergy_id',
            '{{%clergy}}',
            'id',
            'CASCADE'
        );

        // creates index for column `soc_net_id`
        $this->createIndex(
            '{{%idx-clergy_soc_net-soc_net_id}}',
            '{{%clergy_soc_net}}',
            'soc_net_id'
        );

        // add foreign key for table `{{%soc_net}}`
        $this->addForeignKey(
            '{{%fk-clergy_soc_net-soc_net_id}}',
            '{{%clergy_soc_net}}',
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
        // drops foreign key for table `{{%clergy}}`
        $this->dropForeignKey(
            '{{%fk-clergy_soc_net-clergy_id}}',
            '{{%clergy_soc_net}}'
        );

        // drops index for column `clergy_id`
        $this->dropIndex(
            '{{%idx-clergy_soc_net-clergy_id}}',
            '{{%clergy_soc_net}}'
        );

        // drops foreign key for table `{{%soc_net}}`
        $this->dropForeignKey(
            '{{%fk-clergy_soc_net-soc_net_id}}',
            '{{%clergy_soc_net}}'
        );

        // drops index for column `soc_net_id`
        $this->dropIndex(
            '{{%idx-clergy_soc_net-soc_net_id}}',
            '{{%clergy_soc_net}}'
        );

        $this->dropTable('{{%clergy_soc_net}}');
    }
}
