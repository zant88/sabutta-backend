


<?php

use yii\db\Migration;

/**
 * Class m221216_233031_add_role_auth_table
 */
class m221216_233031_add_role_auth_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('role_auth', [
            'id' => $this->primaryKey(),
            'role_id' => $this->integer(),
            'auth_id' => $this->integer()
        ]);

        $this->addForeignKey(
            'fk_role_auth_role_id',
            'role_auth',
            'role_id',
            'role',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_role_auth_auth_id',
            'role_auth',
            'auth_id',
            'auth_master',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_role_auth_role_id', 'role_auth');
        $this->dropTable('role_auth');
    }
}
