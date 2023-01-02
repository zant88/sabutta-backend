<?php

use yii\db\Migration;

/**
 * Class m221221_092604_add_redirect_url
 */
class m221221_092604_add_redirect_url extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('role', 'redirect_path', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('role', 'redirect_path');
    }
}
