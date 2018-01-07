<?php

use yii\db\Migration;

class m180107_023133_alter_order extends Migration
{
    private $_table = '{{%order}}';

    public function safeDown()
    {
        $this->dropColumn($this->_table, "user_id");
    }

    public function safeUp()
    {
        $this->addColumn($this->_table, "user_id",
            $this->integer()->notNull()->after("id")
        );
    }
}

