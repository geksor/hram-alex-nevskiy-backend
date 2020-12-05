<?php

use yii\db\Migration;

/**
 * Handles adding pay_id_and_status to table `{{%orders_app}}`.
 */
class m190726_131632_add_pay_id_and_status_column_to_orders_app_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%orders_app}}', 'pay_id', $this->string());
        $this->addColumn('{{%orders_app}}', 'status', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%orders_app}}', 'pay_id');
        $this->dropColumn('{{%orders_app}}', 'status');
    }
}
