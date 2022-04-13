<?php

use yii\db\Migration;

class m220326_060959_create_table_jenissampah extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%jenissampah}}',
            [
                'idsampah' => $this->string(20)->notNull()->append('PRIMARY KEY'),
                'nama' => $this->string(100),
                'hargaperkg' => $this->double(),
                'desc' => $this->string(),
                'status' => $this->string(20),
                'roleuser' => $this->string(100),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%jenissampah}}');
    }
}
