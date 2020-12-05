<?php

use yii\db\Migration;

/**
 * Handles adding sended to table `{{%donate}}`.
 */
class m190619_114539_add_sended_column_to_donate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%donate}}', 'sended', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%donate}}', 'sended');
    }
}
