<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_second}}`.
 */
class m190628_133819_create_blog_second_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blog_second}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'video_link' => $this->string()->notNull(),
            'publish_at' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'publish' => $this->integer(1)->notNull()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%blog_second}}');
    }
}
