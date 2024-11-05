<?php

use yii\db\Migration;

/**
 * Class m241030_152305_add_field_total
 */
class m241030_152305_add_field_total extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('banksampah_sales', 'total', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('banksampah_sales', 'total');
    }
}
