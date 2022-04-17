<?php

use yii\db\Migration;

/**
 * Class m220417_023126_add_waste_type_in_jenissampah
 */
class m220417_023126_add_waste_type_in_jenissampah extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('jenissampah', 'waste_type_id', $this->integer());
        $this->addForeignKey('fk_jenissampah_waste_type', 'jenissampah', 'waste_type_id', 'waste_type', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_jenissampah_waste_type', 'jenissampah');
        $this->dropColumn('jenissampah', 'waste_type_id');
    }
}
