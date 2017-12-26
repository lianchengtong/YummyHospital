<?php

use yii\db\Migration;

class m171226_145010_department extends Migration
{
    private $_table = '{{%department}}';

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'   => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }
}

