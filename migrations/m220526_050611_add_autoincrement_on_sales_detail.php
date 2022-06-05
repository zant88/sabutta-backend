<?php

use yii\db\Migration;

/**
 * Class m220526_050611_add_autoincrement_on_sales_detail
 */
class m220526_050611_add_autoincrement_on_sales_detail extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%sales}}', 'id', $this->integer().' NOT NULL AUTO_INCREMENT');
        $this->alterColumn('{{%sales_detail}}', 'id', $this->integer().' NOT NULL AUTO_INCREMENT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%sales}}', 'id', $this->integer());
        $this->alterColumn('{{%sales_detail}}', 'id', $this->integer());
    }
}
