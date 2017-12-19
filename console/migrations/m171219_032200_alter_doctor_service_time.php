<?php

use yii\db\Migration;

class m171219_032200_alter_doctor_service_time extends Migration
{
    private $_table = '{{%doctor_service_time}}';

    public function safeUp()
    {
        $this->addColumn($this->_table, "week", $this->string()->notNull()->defaultValue(0)->after("month"));
        $this->addColumn($this->_table, "mode", $this->string()->notNull()->defaultValue(0)->after("doctor_id"));
        $this->addColumn($this->_table, "max_time_long", $this->string()->notNull()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn($this->_table, "week");
        $this->dropColumn($this->_table, "mode");
        $this->dropColumn($this->_table, "max_time_long");
    }
}
