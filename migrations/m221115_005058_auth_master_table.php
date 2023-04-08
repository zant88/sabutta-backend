<?php

use yii\db\Migration;

/**
 * Class m221115_005058_auth_master_table
 */
class m221115_005058_auth_master_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('auth_master', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'description' => $this->text(),
            'module' => $this->string(),
            'controller' => $this->string(),
            'action' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('auth_master');
    }
}
