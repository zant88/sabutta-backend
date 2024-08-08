<?php

use yii\db\Migration;

/**
 * Class m240801_214720_add_withdraw_and_order_detail_banksampah_id_banksampah_code
 */
class m240801_214720_add_withdraw_and_order_detail_banksampah_id_banksampah_code extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('withdraw', 'banksampah_id', $this->integer());
        $this->addColumn('withdraw', 'banksampah_code', $this->string(50));
        $this->addForeignKey(
            'fk_withdraw_banksampah_id',
            'withdraw',
            'banksampah_id',
            'mbanksampah',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addColumn('order_revision', 'banksampah_id', $this->integer());
        $this->addColumn('order_revision', 'banksampah_code', $this->string(50));
        $this->addForeignKey(
            'fk_order_revision_banksampah_id',
            'order_revision',
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
        $this->dropColumn('order_revision', 'banksampah_id');
        $this->dropColumn('order_revision', 'banksampah_code');
        $this->dropColumn('withdraw', 'banksampah_id');
        $this->dropColumn('withdraw', 'banksampah_code');
    }
}
