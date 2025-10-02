<?php

use yii\db\Migration;

/**
 * Class m250221_223032_add_banksampah_type
 */
class m250221_223032_add_banksampah_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('mbanksampah', 'is_saving', $this->boolean(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('mbanksampah', 'is_saving');
    }
}