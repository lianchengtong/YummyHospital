<?php

use yii\db\Migration;

class m171209_085839_link_group extends Migration
{
    private $_table = '{{%link_group}}';

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'   => $this->primaryKey(),
            'name' => $this->string()->notNull()->defaultValue(""),
            'slug' => $this->string()->notNull()->unique(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}

