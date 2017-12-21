<?php

use yii\db\Migration;

class m171221_040807_alter_website_config_item extends Migration
{
    private $_table = '{{%website_config}}';

    public function safeDown()
    {
        $this->dropColumn($this->_table, "hint");
    }

    public function safeUp()
    {
        $this->addColumn($this->_table, "hint", $this->string()->notNull()->defaultValue("")->after("value"));
    }
}

