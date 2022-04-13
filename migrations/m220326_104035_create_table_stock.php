<?php

use yii\db\Migration;

class m220326_104035_create_table_stock extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%stock}}',
            [
                'idstock' => $this->string(20)->notNull()->append('PRIMARY KEY'),
                'idjnssampah' => $this->string(20),
                'nilai' => $this->double(),
                'tgl' => $this->date(),
                'jnsstock' => $this->string(5),
                'idorder' => $this->string(20),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%stock}}');
    }
}
