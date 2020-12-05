<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%donate}}`.
 */
class m190314_101928_create_donate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%donate}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'need' => $this->integer()->notNull(),
            'now' => $this->integer(),
            'publish' => $this->integer(1)->notNull()->defaultValue(0),
            'rank' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'last_donate' => $this->integer(),
            'last_donate_date' => $this->integer(),
            'donate_count' => $this->integer()->notNull()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%donate}}');
    }
}
