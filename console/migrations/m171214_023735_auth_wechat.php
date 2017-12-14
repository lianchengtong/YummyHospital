<?php

use yii\db\Migration;

class m171214_023735_auth_wechat extends Migration
{
    private $_table = '{{%auth_wechat}}';

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'                      => $this->primaryKey(),
            'user_id'                 => $this->integer()->notNull(),
            'open_id'                 => $this->string()->notNull(),
            'access_token'            => $this->string()->notNull(),
            'refresh_token'           => $this->string()->notNull(),
            'refresh_token_expire_at' => $this->integer()->notNull(),
            'access_token_expire_at'  => $this->integer()->notNull(),
            'created_at'              => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}