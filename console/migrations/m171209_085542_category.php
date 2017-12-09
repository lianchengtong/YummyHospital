<?php

use yii\db\Migration;

class m171209_085542_category extends Migration
{
    private $_table = '{{%category}}';

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'   => $this->primaryKey(),
            'name' => $this->string()->notNull()->defaultValue(""),
            'slug' => $this->string()->notNull()->unique(),
            'pid'  => $this->integer()->notNull()->defaultValue(0),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}

