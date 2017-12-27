<?php

use yii\db\Migration;

/**
 * Class m171227_103350_order_mont_data
 */
class m171227_103350_order_mont_data extends Migration
{
    private $_table = '{{%order_mont_data}}';

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'       => $this->primaryKey(),
            'order_id' => $this->string()->notNull(),
            'name'     => $this->string()->notNull(),
            'content'  => $this->string()->notNull(),
        ]);
    }
}

