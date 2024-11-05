<?php

use yii\db\Migration;

/**
 * Class m241023_163910_table_banksampah_sales
 */
class m241023_163910_table_banksampah_sales extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('banksampah_sales', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'from_banksampah_id' => $this->integer(),
            'to_banksampah_id' => $this->integer(),
            'transaction_date' => $this->date(),
            'created_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'status' => $this->string(75),
            'pickup_at' => $this->dateTime(),
            'vehicle_type' => $this->string(100),
            'nopol' => $this->string(15),
            'pickup_name' => $this->string(150),
            'pickup_description' => $this->text()
        ]);

        $this->addForeignKey(
            'fk_banksampah_sales_from_banksampah_id',
            'banksampah_sales',
            'from_banksampah_id',
            'mbanksampah',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_banksampah_sales_to_banksampah_id',
            'banksampah_sales',
            'to_banksampah_id',
            'mbanksampah',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_banksampah_sales_to_created_by',
            'banksampah_sales',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('banksampah_sales_detail', [
            'id' => $this->primaryKey(),
            'banksampah_sales_id' => $this->integer(),
            'sampah_id' => $this->string(20),
            'unit_price' => $this->integer(),
            'quantity' => $this->integer(),
            'amount' => $this->integer()
        ]);

        // $this->addForeignKey(
        //     'fk_banksampah_sales_detail_sampah_id',
        //     'banksampah_sales_detail',
        //     'sampah_id',
        //     'jenissampah',
        //     'idsampah',
        //     'CASCADE',
        //     'CASCADE'
        // );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('banksampah_sales_detail');
        $this->dropTable('banksampah_sales');
    }
}
