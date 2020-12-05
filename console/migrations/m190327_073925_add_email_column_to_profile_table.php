<?php

use yii\db\Migration;

/**
 * Handles adding email to table `{{%profile}}`.
 */
class m190327_073925_add_email_column_to_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%profile}}', 'email', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%profile}}', 'email');
    }
}
