<?php

use yii\db\Migration;

class m220326_104045_create_table_summary extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%summary}}',
            [
                'idsum' => $this->string(20)->notNull()->append('PRIMARY KEY'),
                'tgl' => $this->date()->notNull(),
                'sampahterpilah' => $this->double()->notNull(),
                'sampahgabrukan' => $this->double()->notNull(),
                'sampahresidu' => $this->double()->notNull(),
                'sampahkompos' => $this->double(),
                'foodwaste' => $this->double(),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%summary}}');
    }
}
