<?php

use yii\db\Migration;

/**
 * Class m171220_055842_alter_article
 */
class m171220_055842_alter_article extends Migration
{
    private $_table = '{{%article}}';

    public function safeDown()
    {
        $this->dropColumn($this->_table, 'type');
    }

    public function safeUp()
    {
        $this->addColumn($this->_table, "type", $this->integer()->notNull()->defaultValue(0));
    }
}
