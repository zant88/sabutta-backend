<?php

use yii\db\Migration;

/**
 * Class m241104_135510_add_percentage_profit_in_vendor_table
 */
class m241104_135510_add_percentage_profit_in_vendor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vendor', 'percentage_profit', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('vendor', 'percentge_profit');
    }
}
