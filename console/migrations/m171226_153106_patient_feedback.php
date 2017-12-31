<?php

use yii\db\Migration;

/**
 * Class m171226_153106_patient_feedback
 */
class m171226_153106_patient_feedback extends Migration
{
    private $_table = '{{%patient_feedback}}';

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'             => $this->primaryKey(),
            'doctor_id'      => $this->integer()->notNull(),
            'appointment_id' => $this->integer()->notNull(),
            'mark'           => $this->integer()->notNull(),
            'content'        => $this->string()->notNull(),
            'created_at'     => $this->integer()->notNull(),
            'updated_at'     => $this->integer()->notNull(),
        ]);
    }
}

