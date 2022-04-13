<?php

use yii\db\Migration;

class m220326_103931_create_table_orderdetail extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%orderdetail}}',
            [
                'detailid' => $this->string(20)->notNull()->append('PRIMARY KEY'),
                'idsampah' => $this->string(20)->notNull(),
                'berat' => $this->double()->notNull(),
                'orderid' => $this->string(20)->notNull(),
                'harga' => $this->double()->notNull(),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%orderdetail}}');
    }
}
