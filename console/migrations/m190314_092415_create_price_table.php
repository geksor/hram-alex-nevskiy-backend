<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%price}}`.
 */
class m190314_092415_create_price_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%price}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'avail' => $this->integer(1)->notNull()->defaultValue(0),
            'publish' => $this->integer(1)->notNull()->defaultValue(0),
            'rank' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%price}}');
    }
}
