<?php

use yii\db\Migration;

/**
 * Handles adding sended to table `{{%event_for_home}}`.
 */
class m190529_115041_add_sended_column_to_event_for_home_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%event_for_home}}', 'sended', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%event_for_home}}', 'sended');
    }
}
