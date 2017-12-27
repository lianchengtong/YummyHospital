<?php

use yii\db\Migration;

class m171227_032441_sms_history extends Migration
{
    private $_table = '{{%sms_history}}';

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'         => $this->primaryKey(),
            'phone'      => $this->string()->notNull(),
            'success'    => $this->boolean()->notNull()->defaultValue(true),
            'data'       => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);
    }
}

