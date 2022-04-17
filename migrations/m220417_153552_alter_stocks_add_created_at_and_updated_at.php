<?php

use yii\db\Migration;

/**
 * Class m220417_153552_alter_stocks_add_created_at_and_updated_at
 */
class m220417_153552_alter_stocks_add_created_at_and_updated_at extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('stock', 'created_at', $this->timestamp());
        $this->addColumn('stock', 'updated_at', $this->timestamp()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('stock', 'created_at');
        $this->dropColumn('stock', 'updated_at');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220417_153552_alter_stocks_add_created_at_and_updated_at cannot be reverted.\n";

        return false;
    }
    */
}
