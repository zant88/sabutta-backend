<?php

use yii\db\Migration;

/**
 * Class m240802_000855_add_stock_banksampah_id_banksampah_code
 */
class m240802_000855_add_stock_banksampah_id_banksampah_code extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('stock', 'banksampah_id', $this->integer());
        $this->addColumn('stock', 'banksampah_code', $this->string(50));
        $this->addForeignKey(
            'fk_stock_banksampah_id',
            'stock',
            'banksampah_id',
            'mbanksampah',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('stock', 'banksampah_id');
        $this->dropColumn('stock', 'banksampah_code');
    }
}
