<?php

use yii\db\Migration;

class m180110_152654_user_coin extends Migration
{
    private $_table = '{{%user_coin}}';

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'      => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'coin'    => $this->integer()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}

