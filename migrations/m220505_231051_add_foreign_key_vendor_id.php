<?php

use yii\db\Migration;

/**
 * Class m220505_231051_add_foreign_key_vendor_id
 */
class m220505_231051_add_foreign_key_vendor_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk_vendor_id_sales', 'sales', 'vendor_id', 'vendor', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_vendor_id_sales', 'sales');
    }
}
