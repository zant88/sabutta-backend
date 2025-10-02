<?php

use yii\db\Migration;

/**
 * Class m250221_232651_add_transaction_processing
 */
class m250221_232651_add_transaction_processing extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('transaction_processing', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'start_date' => $this->date(),
            'end_date' => $this->date(),
            'banksampah_id' => $this->integer(),
        ]);
        
        $this->addForeignKey(
            'fk_transaction_processing_user',
            'transaction_processing',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_transaction_processing_banksampah',
            'transaction_processing',
            'banksampah_id',
            'mbanksampah',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('transaction_processing_detail', [
            'id' => $this->primaryKey(),
            'transaction_processing_id' => $this->integer(),
            'waste_id' => $this->string(),
            'prev_price' => $this->integer(),
            'curr_price' => $this->integer(),
            'sales_list' => $this->string()
        ]);

        $this->addForeignKey(
            'fk_transaction_processing_detail_transaction_processing_id',
            'transaction_processing_detail',
            'transaction_processing_id',
            'transaction_processing',
            "id",
            'CASCADE',
            'CASCADE'
        );

        // $this->addForeignKey(
        //     'fk_transaction_processing_detail_waste_id',
        //     'transaction_processing_detail',
        //     'waste_id',
        //     'jenissampah',
        //     "idsampah",
        //     'CASCADE',
        //     'CASCADE'
        // );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('transaction_processing_detail');
        $this->dropTable('transaction_processing');
    }
}
