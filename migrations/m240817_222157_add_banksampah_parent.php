<?php

use yii\db\Migration;

/**
 * Class m240817_222157_add_banksampah_parent
 */
class m240817_222157_add_banksampah_parent extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('mbanksampah', 'updated_at');
        $this->addColumn('mbanksampah', 'updated_at', $this->timestamp()->defaultValue(null));
        $this->addColumn('mbanksampah', 'parent_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('mbanksampah', 'updated_at');
        $this->addColumn('mbanksampah', 'updated_at', $this->timestamp()->defaultValue(null));
        $this->dropColumn('mbanksampah', 'parent_id');
    }
}
