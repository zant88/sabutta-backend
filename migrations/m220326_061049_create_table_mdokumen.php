<?php

use yii\db\Migration;

class m220326_061049_create_table_mdokumen extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%refdokumen}}',
            [
                'iddok' => $this->string(2)->notNull()->append('PRIMARY KEY'),
                'namadok' => $this->string(100),
                'stsaktif' => $this->integer(),
            ],
            $tableOptions
        );

        $this->createTable(
            '{{%mdokumen}}',
            [
                'idfas' => $this->string(20)->notNull(),
                'iddok' => $this->string(100)->notNull(),
                'nodok' => $this->string(100),
                'keterangan' => $this->string(100),
            ],
            $tableOptions
        );

        $this->addPrimaryKey('PRIMARYKEY', '{{%mdokumen}}', ['idfas', 'iddok']);

        $this->addForeignKey(
            'mdokumen_FK',
            '{{%mdokumen}}',
            ['iddok'],
            '{{%refdokumen}}',
            ['iddok'],
            'RESTRICT',
            'RESTRICT'
        );
        $this->addForeignKey(
            'mdokumen_FK_1',
            '{{%mdokumen}}',
            ['idfas'],
            '{{%mfasyankes}}',
            ['idfas'],
            'RESTRICT',
            'RESTRICT'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%mdokumen}}');
        $this->dropTable('{{%refdokumen}}');
    }
}
