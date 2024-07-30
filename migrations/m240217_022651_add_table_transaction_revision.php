<?php

use yii\db\Migration;

/**
 * Class m240217_022651_add_table_transaction_revision
 */
class m240217_022651_add_table_transaction_revision extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order_revision', [
            'id' => $this->primaryKey(),
            'code' => $this->string(50)->notNull(),
            'order_id' => $this->string(50),
            'description' => $this->text(),
            'revision_date' => $this->dateTime(),
        ]);
        // $this->addForeignKey(
        //     'fk_transaction_revision_order_id',
        //     'transaction_revision',
        //     'order_id',
        //     'order',
        //     'idorder',
        //     'CASCADE',
        //     'CASCADE'
        // );

        $this->createTable('order_revision_detail', [
            'id' => $this->primaryKey(),
            'order_revision_id' => $this->integer(),
            'sampah_id' => $this->string(20),
            'amount_diminished' => $this->integer(),
        ]);
        // $this->addForeignKey(
        //     'fk_trx_revision_detail_transaction_revision_id',
        //     'trx_revision_detail',
        //     'transaction_revision_id',
        //     'transaction_revision',
        //     'id',
        //     'CASCADE',
        //     'CASCADE'
        // );
        // $this->addForeignKey(
        //     'fk_trx_revision_detail_sampah_id',
        //     'trx_revision_detail',
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
        $this->dropTable('order_revsion_detail');
        $this->dropTable('order_revision');
    }
}
