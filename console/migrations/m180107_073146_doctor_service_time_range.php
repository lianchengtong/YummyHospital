<?php

use yii\db\Migration;

/**
 * Class m180107_073146_doctor_service_time_range
 */
class m180107_073146_doctor_service_time_range extends Migration
{
    private $_table = '{{%doctor_service_time_range}}';

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'        => $this->primaryKey(),
            'doctor_id' => $this->integer()->notNull(),
            'begin'     => $this->string()->notNull(),
            'end'       => $this->string()->notNull(),
            'count'        => $this->integer()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}

