<?php

use yii\db\Migration;

class m220326_060919_create_table_driver extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%driver}}',
            [
                'iddriver' => $this->string(20)->notNull()->append('PRIMARY KEY'),
                'nama' => $this->string(50),
                'nmperusahaan' => $this->string(200),
                'telppersh' => $this->string(20),
                'telpdriver' => $this->string(20),
                'lat' => $this->string(50),
                'lon' => $this->string(20),
                'sts' => $this->string(50),
                'stsjob' => $this->string(20),
                'foto' => $this->binary(),
                'userid' => $this->string(10)->notNull(),
                'pass' => $this->string()->notNull(),
                'tokenfb' => $this->string(),
                'role' => $this->string(100),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%driver}}');
    }
}
