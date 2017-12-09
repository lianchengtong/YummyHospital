<?php

use yii\db\Migration;

/**
 * Class m171209_092947_doctor_appointment_patient_info
 */
class m171209_092947_doctor_appointment_patient_info extends Migration
{
    private $_table = '{{%doctor_appointment_patient_info}}';

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'             => $this->primaryKey(),
            'appointment_id' => $this->integer()->notNull(),
            'username'       => $this->string()->notNull(),
            'phone'          => $this->string()->notNull()->defaultValue(""),
            'memo'           => $this->text(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}

