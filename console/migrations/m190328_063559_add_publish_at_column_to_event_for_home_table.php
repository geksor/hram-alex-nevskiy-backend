<?php

use yii\db\Migration;

/**
 * Handles adding publish_at to table `{{%event_fo_home}}`.
 */
class m190328_063559_add_publish_at_column_to_event_for_home_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%event_for_home}}', 'publish_at', $this->integer()->notNull());
        $this->addColumn('{{%event_for_home}}', 'publish', $this->integer(1)->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%event_for_home}}', 'publish_at');
        $this->dropColumn('{{%event_for_home}}', 'publish');
    }
}
