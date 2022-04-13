<?php

use yii\db\Migration;

class m220326_103945_create_table_places extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%places}}',
            [
                'idplace' => $this->string(20)->notNull()->append('PRIMARY KEY'),
                'name' => $this->string(100)->notNull(),
                'jenis' => $this->string(50),
                'stsaktif' => $this->string(20),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%places}}');
    }
}
