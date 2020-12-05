<?php

use yii\db\Migration;

/**
 * Handles adding sended to table `{{%calendar_events}}`.
 */
class m190529_130143_add_sended_column_to_calendar_events_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%calendar_events}}', 'sended', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%calendar_events}}', 'sended');
    }
}
