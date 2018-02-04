<?php

use yii\db\Migration;

class m180204_143358_card_password extends Migration
{
    private $_table = "{{%card_password}}";

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'       => $this->primaryKey(),
            'user_id'  => $this->integer()->notNull(),
            'password' => $this->string()->notNull(),
            'salt'     => $this->string()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}
