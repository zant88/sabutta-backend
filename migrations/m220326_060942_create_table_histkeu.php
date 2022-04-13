<?php

use yii\db\Migration;

class m220326_060942_create_table_histkeu extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%histkeu}}',
            [
                'idkeu' => $this->string(20)->notNull()->append('PRIMARY KEY'),
                'idfasyankes' => $this->string(20),
                'status' => $this->string(10),
                'value' => $this->double(),
                'tglhist' => $this->dateTime(),
                'idOrder' => $this->string(20),
                'keterangan' => $this->string(100),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%histkeu}}');
    }
}
