<?php

use yii\db\Migration;

/**
 * Class m240801_232343_add_jenissampah_banksampah_id_banksampah_code
 */
class m240801_232343_add_jenissampah_banksampah_id_banksampah_code extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('order', 'banksampah_id', $this->integer());
        $this->addColumn('order', 'banksampah_code', $this->string(50));
        $this->addForeignKey(
            'fk_order_banksampah_id',
            'order',
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
        $this->dropColumn('order', 'banksampah_id');
        $this->dropColumn('order', 'banksampah_code');
    }

}
