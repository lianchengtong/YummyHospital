<?php

use yii\db\Migration;

class m180107_133438_alter_my_patient extends Migration
{
    private $_table = '{{%my_patient}}';

    public function safeUp()
    {
        $this->addColumn($this->_table, "default", $this->boolean()->notNull()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn($this->_table, "default");
    }
}

