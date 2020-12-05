<?php

use yii\db\Migration;

/**
 * Handles adding type to table `{{%service}}`.
 */
class m190710_125751_add_type_column_to_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%service}}', 'type', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%service}}', 'type');
    }
}
