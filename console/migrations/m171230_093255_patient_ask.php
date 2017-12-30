<?php

use yii\db\Migration;

class m171230_093255_patient_ask extends Migration
{
    private $_table = '{{%patient_ask}}';

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'          => $this->primaryKey(),
            'user_id'     => $this->integer()->notNull(),
            'doctor_id'   => $this->integer()->notNull(),
            'patient_id'  => $this->integer()->notNull(),
            'description' => $this->text()->notNull(),
            'images'      => $this->text(),
            'reply'       => $this->text(),
            'reply_at'    => $this->integer(),
            'created_at'  => $this->integer(),
            'updated_at'  => $this->integer(),
        ]);
    }
}

