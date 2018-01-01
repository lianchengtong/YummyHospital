<?php

use yii\db\Migration;

class m180101_072158_alter_my_patient extends Migration
{
    private $_table = '{{%my_patient}}';

    public function safeUp()
    {
        $this->addColumn($this->_table, "relation", $this->integer()->notNull()->defaultValue(0));
        $this->addColumn($this->_table, "height", $this->integer()->notNull()->defaultValue(0));
        $this->addColumn($this->_table, "weight", $this->integer()->notNull()->defaultValue(0));
        $this->addColumn($this->_table, "is_self", $this->smallInteger(2)->notNull()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn($this->_table, "relation");
        $this->dropColumn($this->_table, "height");
        $this->dropColumn($this->_table, "weight");
        $this->dropColumn($this->_table, "is_self");
    }
}
