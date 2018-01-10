<?php

use yii\db\Migration;

class m180110_155318_promotion_card extends Migration
{
    private $_table = '{{%promotion_card}}';

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'          => $this->primaryKey(),
            'user_id'     => $this->integer()->notNull()->defaultValue(0),
            'card_number' => $this->string()->notNull(),
            'card_worth'  => $this->integer()->notNull(),
            'batch_code'  => $this->string()->notNull(),
            'active_at'   => $this->integer()->notNull()->defaultValue(0),
            'created_at'  => $this->integer()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}

