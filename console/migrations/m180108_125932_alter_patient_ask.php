<?php

use yii\db\Migration;

class m180108_125932_alter_patient_ask extends Migration
{
    private $_table = '{{%patient_ask}}';

    public function safeDown()
    {
        $this->dropColumn($this->_table, "pay_status");
    }

    public function safeUp()
    {
        $this->addColumn($this->_table, "pay_status",
            $this->integer()->notNull()->defaultValue(0)->after("reply_at")
        );
    }
}

