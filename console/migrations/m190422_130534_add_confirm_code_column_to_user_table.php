<?php

use yii\db\Migration;

/**
 * Handles adding confirm_code to table `{{%user}}`.
 */
class m190422_130534_add_confirm_code_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'confirm_code', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'confirm_code');
    }
}
