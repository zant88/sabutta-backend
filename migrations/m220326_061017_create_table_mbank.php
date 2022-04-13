<?php

use yii\db\Migration;

class m220326_061017_create_table_mbank extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%mfasyankes}}',
            [
                'idfas' => $this->string(20)->notNull()->append('PRIMARY KEY'),
                'alamat' => $this->string(),
                'telp' => $this->string(20),
                'fax' => $this->string(20),
                'owner' => $this->string(50),
                'namapetugas' => $this->string(50),
                'jabatanpetugas' => $this->string(50),
                'npwp' => $this->string(50),
                'email' => $this->string(30),
                'website' => $this->string(100),
                'bidangusaha' => $this->string(100),
                'notaris' => $this->string(50),
                'alamatnotaris' => $this->string(),
                'nomoraktenotaris' => $this->string(100),
                'tglaktenotaris' => $this->date(),
                'nosiup' => $this->string(100),
                'pkp' => $this->string(100),
                'nodomisilipersh' => $this->string(100),
                'notandapersh' => $this->string(100),
                'userid' => $this->string(50)->notNull(),
                'pass' => $this->string()->notNull(),
                'namafas' => $this->string(100),
                'ttdmanagement' => $this->binary(),
                'ttdclient' => $this->binary(),
                'lat' => $this->string(50),
                'lon' => $this->string(100),
                'tokenfb' => $this->string(),
                'role' => $this->string(100),
                'tglinput' => $this->dateTime(),
                'nip' => $this->string(50),
                'nik' => $this->string(50),
                'saldo' => $this->double(),
            ],
            $tableOptions
        );

        $this->createTable(
            '{{%mbank}}',
            [
                'idbank' => $this->string(20)->notNull()->append('PRIMARY KEY'),
                'namabank' => $this->string(100),
                'alamat' => $this->string(100),
                'norekening' => $this->string(100),
                'keterangan' => $this->string(),
                'idfas' => $this->string(20),
            ],
            $tableOptions
        );

        $this->addForeignKey(
            'mbank_FK',
            '{{%mbank}}',
            ['idfas'],
            '{{%mfasyankes}}',
            ['idfas'],
            'RESTRICT',
            'RESTRICT'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%mbank}}');
        $this->dropTable('{{%mfasyankes}}');
    }
}
