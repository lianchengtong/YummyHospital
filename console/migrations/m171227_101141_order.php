<?php

use yii\db\Migration;

class m171227_101141_order extends Migration
{
    private $_table = '{{%sms_history}}';

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'           => $this->primaryKey(),
            'order_id'     => $this->string()->notNull(),
            'out_trade_id' => $this->string()->notNull(),
            'channel'      => $this->string()->notNull(),
            'name'         => $this->string()->notNull(),
            'price'        => $this->integer()->notNull(), // 分为单位
            'status'       => $this->integer()->notNull(),
            'complete_at'  => $this->integer()->notNull(),
            'created_at'   => $this->integer()->notNull(),
            'updated_at'   => $this->integer()->notNull(),
        ]);
    }
}

