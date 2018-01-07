<?php

use yii\db\Migration;

class m180107_023822_member_card_pay_log extends Migration
{
    private $_table = '{{%member_card_pay_log}}';

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'         => $this->primaryKey(),
            'card_id'    => $this->integer()->notNull(),
            'order_id'   => $this->integer()->notNull(),
            'pay_price'  => $this->double()->notNull(),
            'card_price' => $this->double()->notNull(),
            'created_at' => $this->integer(),
        ]);
    }
}

