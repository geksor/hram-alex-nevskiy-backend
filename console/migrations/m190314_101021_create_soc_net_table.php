<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%soc_net}}`.
 */
class m190314_101021_create_soc_net_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%soc_net}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'pre_link' => $this->string(),
            'image_svg' => $this->text(),
            'description' => $this->text(),
            'publish' => $this->integer(1)->notNull()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%soc_net}}');
    }
}
