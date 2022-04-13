<?php

use yii\db\Migration;

/**
 * Class m220327_162024_alter_vendor_add_phone
 */
class m220327_162024_alter_vendor_add_phone extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vendor', 'phone', $this->string(35));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('vendor', 'phone');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220327_162024_alter_vendor_add_phone cannot be reverted.\n";

        return false;
    }
    */
}
