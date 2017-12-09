<?php

use yii\db\Migration;

/**
 * Class m171209_093225_doctor_appointment_track
 */
class m171209_093225_doctor_appointment_track extends Migration
{
    private $_table = '{{%doctor_appointment_track}}';

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'             => $this->primaryKey(),
            'user_id'        => $this->integer()->notNull(),
            'appointment_id' => $this->integer()->notNull(),
            'track_message'  => $this->string()->notNull()->defaultValue(""),
            'created_at'     => $this->integer(),
            'updated_at'     => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}

