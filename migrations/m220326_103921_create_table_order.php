<?php

use yii\db\Migration;

class m220326_103921_create_table_order extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%order}}',
            [
                'idorder' => $this->string(50)->notNull()->append('PRIMARY KEY'),
                'idfasyankes' => $this->string(20),
                'iddriver' => $this->string(20),
                'tanggalinput' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'tanggalrequest' => $this->dateTime(),
                'tanggalpickup' => $this->dateTime(),
                'berat' => $this->double(),
                'status' => $this->string(20),
                'distance' => $this->double(),
                'feekir' => $this->double(),
                'feesam' => $this->double(),
                'lokasipenjemputan' => $this->string(100),
                'jnsTrxRequest' => $this->string(20),
                'userpengurai' => $this->string(20),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }
}
