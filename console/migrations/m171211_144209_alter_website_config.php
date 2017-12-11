<?php

use yii\db\Migration;

/**
 * Class m171211_144209_alter_website_config
 */
class m171211_144209_alter_website_config extends Migration
{
    private $_table = '{{%website_config}}';

    public function safeUp()
    {
        $this->addColumn($this->_table, "name", $this->string()->notNull()->defaultValue("")->after("key"));
    }

    public function safeDown()
    {
        $this->dropColumn($this->_table, "name");
    }
}

