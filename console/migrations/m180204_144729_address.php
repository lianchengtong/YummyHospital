<?php

use yii\db\Migration;

class m180204_144729_address extends Migration
{
    private $_table = "{{%address}}";

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'       => $this->primaryKey(),
            'user_id'  => $this->integer()->notNull(),
            'name'     => $this->string()->notNull(),
            'phone'    => $this->string()->notNull(),
            'location' => $this->string()->notNull(),
            'default'  => $this->integer()->notNull()->defaultValue(0),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}
