<?php

use yii\db\Migration;

/**
 * Class m220411_100210_vendor_waste_table
 */
class m220411_100210_vendor_waste_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vendor_waste', [
            'id' => $this->primaryKey(),
            'idsampah' => $this->string(20)->notNull(),
            'vendor_id' => $this->integer()->notNull(),
            'price_kg' => $this->integer()->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->addForeignKey(
            'fk-vendor_table-vendor_id', 'vendor_waste', 'vendor_id', 
            'vendor', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey(
            'fk-vendor_table-idsampah', 'vendor_waste', 
            'idsampah', 'jenissampah', 'idsampah', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-vendor_table-vendor_id', 'vendor_waste');
        $this->dropForeignKey('fk-vendor_table-idsampah', 'vendor_waste');
        $this->dropTable('vendor_waste');
    }
}
