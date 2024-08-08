<?php

use yii\db\Migration;

/**
 * Class m240801_002236_add_user_banksampah_id_banksampah_code
 */
class m240801_002236_add_user_banksampah_id_banksampah_code extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'banksampah_id', $this->integer());
        $this->addColumn('user', 'banksampah_code', $this->string(50));
        $this->addForeignKey(
            'fk_user_banksampah_od',
            'user',
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
        $this->dropColumn('user', 'banksampah_id');
        $this->dropColumn('user', 'banksampah_code');
    }

}
