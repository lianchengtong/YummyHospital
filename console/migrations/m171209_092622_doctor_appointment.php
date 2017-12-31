<?php

use yii\db\Migration;

/**
 * Class m171209_092622_doctor_apppintment
 */
class m171209_092622_doctor_appointment extends Migration
{
    private $_table = '{{%doctor_appointment}}';

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'           => $this->primaryKey(),
            'user_id'      => $this->integer()->notNull(),
            'doctor_id'    => $this->integer()->notNull(),
            'patient_id'   => $this->integer()->notNull(),
            'time_begin'   => $this->integer()->notNull()->defaultValue(0),
            'time_end'     => $this->integer()->notNull()->defaultValue(0),
            'order_number' => $this->integer()->notNull(),
            'status'       => $this->integer()->notNull(),
            'created_at'   => $this->integer(),
            'updated_at'   => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}
