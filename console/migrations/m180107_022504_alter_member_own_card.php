<?php

use yii\db\Migration;

class m180107_022504_alter_member_own_card extends Migration
{
    private $_table = '{{%member_own_card}}';

    public function safeDown()
    {
        $this->dropColumn($this->_table, "is_enable");
    }

    public function safeUp()
    {
        $this->addColumn($this->_table, "is_enable",
            $this->boolean()->notNull()->defaultValue(true)->after("expire_at")
        );
    }
}

