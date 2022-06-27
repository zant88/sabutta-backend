<?php

use yii\db\Migration;

/**
 * Class m220619_095014_add_primary_key_order
 */
class m220619_095014_add_primary_key_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('sales', 'invoiced', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('sales', 'invoiced');
    }
}
