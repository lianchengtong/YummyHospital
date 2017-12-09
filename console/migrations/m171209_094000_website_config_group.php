<?php

use yii\db\Migration;

/**
 * Class m171209_094000_website_config_group
 */
class m171209_094000_website_config_group extends Migration
{
    private $_table = '{{%website_config_group}}';

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'         => $this->primaryKey(),
            'name'       => $this->string()->notNull(),
            'order'      => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}
