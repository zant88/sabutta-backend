<?php

use yii\db\Migration;

/**
 * Class m220326_131016_add_table_sales_and_sales_detail
 */
class m220326_131016_add_table_sales_and_sales_detail extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sales}}', [
            'id' => $this->primaryKey(),
            'vendor_id' => $this->integer()->notNull(),
            'code' => $this->string()->notNull(),
            'sales_date' => $this->dateTime()->notNull(),
            'total' => $this->integer()->notNull(),
            'status' => $this->string(),
        ]);

        $this->createTable('{{%sales_detail}}', [
            'id' => $this->primaryKey(),
            'sales_id' => $this->integer()->notNull(),
            'sampah_id' => $this->string(20)->notNull(),
            'amount_kg' => $this->dateTime()->notNull(),
            'total_price' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'sales_detail_FK_sales_id',
            '{{%sales_detail}}',
            ['sales_id'],
            '{{%sales}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sales_detail}}');
        $this->dropTable('{{%sales}}');
    }
}
