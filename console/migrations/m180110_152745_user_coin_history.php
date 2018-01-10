<?php

use yii\db\Migration;

/**
 * Class m180110_152745_user_coin_history
 */
class m180110_152745_user_coin_history extends Migration
{
    private $_table = '{{%user_coin_history}}';

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'         => $this->primaryKey(),
            'user_id'    => $this->integer()->notNull(),
            'coin'       => $this->integer()->notNull(),
            'action'     => $this->string(1)->notNull(),
            'desc'       => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}

