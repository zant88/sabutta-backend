<?php

use yii\db\Migration;

/**
 * Class m220620_035546_add_invoice
 */
class m220620_035546_add_invoice extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('invoice', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'date' => $this->dateTime(),
            'hormat_kami_name' => $this->string(),
            'place' => $this->string(),
            'hormat_kami_position' => $this->string(),
            'active_status' => $this->boolean()->defaultValue(true),
            'description' => $this->text() 
        ]);

        $this->createTable('invoice_detail', [
            'id' => $this->primaryKey(),
            'invoice_id' => $this->integer(),
            'sales_id' => $this->integer(),
        ]);

        $this->addForeignKey('fk_invoice_detail_invoice_id', 'invoice_detail', 'invoice_id', 'invoice', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('invoice_detail');
        $this->dropTable('invoice');
    }
}
