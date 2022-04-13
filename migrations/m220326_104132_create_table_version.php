<?php

use yii\db\Migration;

class m220326_104132_create_table_version extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%version}}',
            [
                'idversion' => $this->primaryKey(),
                'version' => $this->string(20)->notNull(),
                'tglrelease' => $this->date()->notNull(),
                'keterangan' => $this->string(),
                'link' => $this->string(),
                'apps' => $this->string(20),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%version}}');
    }
}
