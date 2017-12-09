<?php

use yii\db\Migration;

/**
 * Class m171209_091140_doctor_service_time
 */
class m171209_091140_doctor_service_time extends Migration
{
    private $_table = '{{%doctor_service_time}}';

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'        => $this->primaryKey(),
            'docker_id' => $this->integer()->notNull(),
            'month'     => $this->string()->notNull(),
            'day'       => $this->string()->notNull(),
            'am'        => $this->string()->notNull(),
            'pm'        => $this->string()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}

