<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clergy}}`.
 */
class m190314_094337_create_clergy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clergy}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'chin' => $this->string(),
            'position' => $this->string(),
            'birthday' => $this->integer(),
            'name_day' => $this->integer(),
            'jericho_ordination' => $this->integer(),
            'deacon_ordination' => $this->integer(),
            'education' => $this->text(),
            'service_places' => $this->text(),
            'rewards' => $this->text(),
            'photo' => $this->string(),
            'publish' => $this->integer(1)->notNull()->defaultValue(0),
            'abbot' => $this->integer(1)->notNull()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clergy}}');
    }
}
