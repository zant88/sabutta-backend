<?php

use yii\db\Migration;

/**
 * Class m220412_231316_change_dateformat_amount_kg
 */
class m220412_231316_change_dateformat_amount_kg extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('sales_detail', 'amount_kg', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('sales_detail', 'amount_kg', $this->dateTime());
    }
}
