<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%moleben_items}}`.
 */
class m190711_134319_create_moleben_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%moleben_items}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'rank' => $this->integer(),
            'publish' => $this->integer(1)->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%moleben_items}}');
    }
}
