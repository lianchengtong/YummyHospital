<?php

use yii\db\Migration;

class m171226_151508_doctor_tag extends Migration
{
    private $_table = '{{%doctor_tag}}';

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'        => $this->primaryKey(),
            'doctor_id' => $this->string()->notNull(),
            'name'      => $this->string()->notNull(),
        ]);
    }
}

