<?php

use yii\db\Migration;

/**
 * Class m241104_235052_add_banksampah_id_and_banksampah_sales_id_on_sales
 */
class m241104_235052_add_banksampah_id_and_banksampah_sales_id_on_sales extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('sales', 'banksampah_id', $this->integer());
        $this->addColumn('sales', 'banksampah_sales_id', $this->integer());

        $this->addForeignKey(
            'fk_sales_banksampah_id',
            'sales',
            'banksampah_id',
            'mbanksampah',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_sales_banksampah_sales_id',
            'sales',
            'banksampah_sales_id',
            'banksampah_sales',
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
        $this->dropColumn('sales', 'banksampah_sales_id');
        $this->dropColumn('sales', 'banksampah_id');
    }
}
