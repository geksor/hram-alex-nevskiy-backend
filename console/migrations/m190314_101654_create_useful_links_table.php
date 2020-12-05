<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%useful_links}}`.
 */
class m190314_101654_create_useful_links_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%useful_links}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'link' => $this->string()->notNull(),
            'rank' => $this->integer(),
            'publish' => $this->integer(1)->notNull()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%useful_links}}');
    }
}
