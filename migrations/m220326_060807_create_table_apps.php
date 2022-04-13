<?php

use yii\db\Migration;

class m220326_060807_create_table_apps extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%apps}}',
            [
                'idapps' => $this->string(20)->notNull()->append('PRIMARY KEY'),
                'desc' => $this->string(),
                'value' => $this->string(),
                'imgs' => $this->binary(),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%apps}}');
    }
}
