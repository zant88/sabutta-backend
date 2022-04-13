<?php

use yii\db\Migration;

class m220326_103903_create_table_mrole extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%mrole}}',
            [
                'idrole' => $this->string(20)->notNull()->append('PRIMARY KEY'),
                'namarole' => $this->string(100),
                'stsaktif' => $this->string(10),
                'idfas' => $this->string(8),
                'alamat' => $this->string(16),
                'telp' => $this->string(1),
                'fax' => $this->string(1),
                'owner' => $this->string(1),
                'namapetugas' => $this->string(1),
                'jabatanpetugas' => $this->string(16),
                'npwp' => $this->string(1),
                'email' => $this->string(1),
                'website' => $this->string(1),
                'bidangusaha' => $this->string(1),
                'notaris' => $this->string(1),
                'alamatnotaris' => $this->string(1),
                'nomoraktenotaris' => $this->string(1),
                'tglaktenotaris' => $this->string(1),
                'nosiup' => $this->string(1),
                'pkp' => $this->string(1),
                'nodomisilipersh' => $this->string(1),
                'notandapersh' => $this->string(1),
                'userid' => $this->string(8),
                'pass' => $this->string(32),
                'namafas' => $this->string(16),
                'ttdmanagement' => $this->string(1),
                'ttdclient' => $this->string(1),
                'lat' => $this->string(16),
                'lon' => $this->string(16),
                'tokenfb' => $this->string(256),
                'role' => $this->string(32),
                'tglinput' => $this->string(32),
                'saldo' => $this->integer(),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%mrole}}');
    }
}
