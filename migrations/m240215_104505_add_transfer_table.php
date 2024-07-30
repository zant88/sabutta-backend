<?php

use yii\db\Migration;

/**
 * Class m240215_104505_add_transfer_table
 */
class m240215_104505_add_transfer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('withdraw', [
            'id' => $this->primaryKey(),
            'idfas' => $this->string(20),
            'idbank' => $this->string(20),
            'amount' => $this->integer(),
            'status' => $this->string(35), // requested, approved, transfered
            'request_date' => $this->dateTime(),
            'transfer_date' => $this->dateTime()
        ]);

        // $this->addForeignKey(
        //     'fk_withdraw_idfas',
        //     'withdraw',
        //     'idfas',
        //     'mfasyankes',
        //     'idfas',
        //     'CASCADE',
        //     'CASCADE'
        // );
        // $this->addForeignKey(
        //     'fk_withdraw_idbank',
        //     'withdraw',
        //     'idbank',
        //     'mbank',
        //     'idbank',
        //     'CASCADE',
        //     'CASCADE'
        // );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('withdraw');
    }
}
