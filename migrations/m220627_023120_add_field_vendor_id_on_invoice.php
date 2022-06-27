<?php

use yii\db\Migration;

/**
 * Class m220627_023120_add_field_vendor_id_on_invoice
 */
class m220627_023120_add_field_vendor_id_on_invoice extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('invoice', 'vendor_id', $this->integer());
        $this->addForeignKey('fk_invoice_vendor_id', 'invoice', 'vendor_id', 'vendor', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('invoice', 'vendor_id');
    }
}
