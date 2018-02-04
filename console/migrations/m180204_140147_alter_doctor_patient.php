<?php

use yii\db\Migration;

class m180204_140147_alter_doctor_patient extends Migration
{
    private $_table = "{{%doctor_appointment}}";

    public function safeUp()
    {
        $this->addColumn($this->_table, "feedback_at", $this->integer()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn($this->_table, "feedback_at");
    }
}