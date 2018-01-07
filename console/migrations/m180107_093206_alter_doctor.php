<?php

use yii\db\Migration;

/**
 * Class m180107_093206_alter_doctor
 */
class m180107_093206_alter_doctor extends Migration
{
    private $_table = '{{%doctor}}';

    public function safeDown()
    {
        $this->dropColumn($this->_table, "enable_ask");
        $this->dropColumn($this->_table, "ask_price");
    }

    public function safeUp()
    {
        $this->addColumn($this->_table, "enable_ask",
            $this->boolean()->notNull()->defaultValue(0)
        );

        $this->addColumn($this->_table, "ask_price",
            $this->integer()->notNull()->defaultValue(20)
        );
    }
}

