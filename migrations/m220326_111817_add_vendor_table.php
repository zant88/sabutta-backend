<?php

use yii\db\Migration;

/**
 * Class m220326_111817_add_vendor_table
 */
class m220326_111817_add_vendor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vendor}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'address' => $this->text(),
            'description' => $this->text(),
            'status' => $this->boolean()->defaultValue(true),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vendor}}');
    }
}
