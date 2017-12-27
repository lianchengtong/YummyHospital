<?php

use yii\db\Migration;

class m171227_151505_my_patient extends Migration
{
    private $_table = '{{%my_patient}}';

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'       => $this->primaryKey(),
            'user_id'  => $this->integer()->notNull(),
            'name'     => $this->string()->notNull(),
            'sex'      => $this->smallInteger(2)->notNull(),
            'birth'    => $this->string()->notNull(),
            'phone'    => $this->string()->notNull(),
            'identify' => $this->string()->notNull(),
        ]);
    }
}

