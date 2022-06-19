<?php

use yii\db\Migration;

/**
 * Class m220619_095014_add_primary_key_order
 */
class m220619_095014_add_primary_key_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addPrimaryKey('pk_table_order', 'order', 'idorder');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropPrimaryKey('pk_table_order', 'order');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220619_095014_add_primary_key_order cannot be reverted.\n";

        return false;
    }
    */
}
