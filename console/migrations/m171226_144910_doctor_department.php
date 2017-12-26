<?php

use yii\db\Migration;

class m171226_144910_doctor_department extends Migration
{
    private $_table = '{{%doctor_department}}';

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'            => $this->primaryKey(),
            'doctor_id'     => $this->integer()->notNull(),
            'department_id' => $this->integer()->notNull(),
        ]);
    }
}

