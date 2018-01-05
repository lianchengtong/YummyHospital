<?php

use yii\db\Migration;

class m180105_020922_member_card extends Migration
{
    private $_table = '{{%member_card}}';

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'           => $this->primaryKey(),
            'name'         => $this->string()->notNull(),
            'price'        => $this->integer()->notNull(),
            'discount'     => $this->integer()->notNull(),
            'pay_discount' => $this->integer()->notNull(),
            'description'  => $this->text(),
            'time_long'    => $this->integer()->notNull()->defaultValue(0),
            'order'        => $this->integer()->notNull()->defaultValue(0),
            'created_at'   => $this->integer(),
            'updated_at'   => $this->integer(),
        ]);
    }
}

