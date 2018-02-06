<?php

use yii\db\Migration;

class m180206_144027_alter_doctor extends Migration
{
    private $_table = "{{%doctor}}";

    public function safeUp()
    {
        $this->addColumn($this->_table, "type", $this->integer()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn($this->_table, "type");
    }
}

