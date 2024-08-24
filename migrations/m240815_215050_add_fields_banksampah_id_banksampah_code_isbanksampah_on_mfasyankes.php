<?php

use yii\db\Migration;

/**
 * Class m240815_215050_add_fields_banksampah_id_banksampah_code_isbanksampah_on_mfasyankes
 */
class m240815_215050_add_fields_banksampah_id_banksampah_code_isbanksampah_on_mfasyankes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('mfasyankes', 'banksampah_id', $this->integer());
        $this->addColumn('mfasyankes', 'banksampah_code', $this->string(50));
        $this->addColumn('mfasyankes', 'isbanksampah', $this->integer()->defaultValue(0));
        $this->addForeignKey(
            'fk_mfasyankes_banksampah_id',
            'mfasyankes',
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
        $this->dropColumn('mfasyankes', 'isbanksampah');
        $this->dropColumn('mfasyankes', 'banmsampah_code');
        $this->dropColumn('mfasyankes', 'banmsampah_id');
    }
}
