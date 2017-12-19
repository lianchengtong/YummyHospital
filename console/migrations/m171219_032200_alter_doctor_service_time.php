<?php

use yii\db\Migration;

class m171219_032200_alter_doctor_service_time extends Migration
{
    private $_table = '{{%doctor_service_time}}';

    public function safeDown()
    {
        $this->dropColumn($this->_table, "week");
        $this->dropColumn($this->_table, "mode");
        $this->dropColumn($this->_table, "max_time_long");
        $this->dropColumn($this->_table, "ticket_count");
        $this->dropColumn($this->_table, "week_service_start_at");
        $this->dropColumn($this->_table, "price");
    }

    public function safeUp()
    {
        $this->addColumn($this->_table, "week", $this->string()->notNull()->defaultValue(0)->after("month"));
        $this->addColumn($this->_table, "mode", $this->string()->notNull()->defaultValue(0)->after("doctor_id"));
        $this->addColumn($this->_table, "max_time_long", $this->string()->notNull()->defaultValue(0));
        $this->addColumn($this->_table, "ticket_count", $this->integer()->notNull()->defaultValue(0)->after("doctor_id"));
        $this->addColumn($this->_table, "week_service_start_at", $this->string()->notNull()->defaultValue(0)->after("week"));
        $this->addColumn($this->_table, "price", $this->integer()->notNull()->defaultValue(0)->after("doctor_id"));
    }
}
