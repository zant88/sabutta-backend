<?php

use yii\db\Migration;

/**
 * Class m220507_011113_add_field_letter_of_code
 */
class m220507_011113_add_field_letter_of_code extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('sales', 'surat_jalan_code', $this->string(30));
        $this->addColumn('sales', 'generated_date_surat_jalan', $this->dateTime());
        $this->addColumn('sales', 'description', $this->text());
        $this->addColumn('sales', 'place', $this->string(100));
        $this->addColumn('sales', 'hormat_kami_name', $this->string(100));
        $this->addColumn('sales', 'hormat_kami_position', $this->string(100));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('sales', 'generated_date_surat_jalan');
        $this->dropColumn('sales', 'surat_jalan_code');
        $this->dropColumn('sales', 'description');
        $this->dropColumn('sales', 'place');
        $this->dropColumn('sales', 'hormat_kami_name');
        $this->dropColumn('sales', 'hormat_kami_position');
    }
}
