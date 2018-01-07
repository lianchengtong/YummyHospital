<?php

use yii\db\Migration;

class m180105_021612_member_own_card extends Migration
{
    private $_table = '{{%member_own_card}}';

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'             => $this->primaryKey(),
            'user_id'        => $this->integer()->notNull(),
            'original_money' => $this->double()->notNull(),
            'remain_money'   => $this->double()->notNull(),
            'discount'       => $this->integer()->notNull(),
            'expire_at'      => $this->integer(),
            'created_at'     => $this->integer(),
        ]);
    }
}

