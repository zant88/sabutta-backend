<?php

use yii\db\Migration;

/**
 * Class m220515_233640_add_tables_cash_in_cash_out
 */
class m220515_233640_add_tables_cash_in_cash_out extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('transaction', [
            'id' => $this->primaryKey(),
            'type' => $this->string(),
            'description' => $this->text(),
            'cash_in' => $this->integer()->defaultValue(0),
            'cash_out' => $this->integer()->defaultValue(0),
            'created_date' => $this->dateTime(),
            'user_id' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('transaction');
    }
}
