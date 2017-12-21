<?php

use yii\db\Migration;

class m171221_060140_code_block extends Migration
{
    private $_table = '{{%code_block}}';

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'    => $this->primaryKey(),
            'name'  => $this->string()->notNull()->defaultValue(""),
            'slug'  => $this->string()->notNull()->unique(),
            'code'  => $this->text()->notNull(),
            'order' => $this->integer()->notNull()->defaultValue(0),
        ]);
    }
}

