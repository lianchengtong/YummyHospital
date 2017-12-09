<?php

use yii\db\Migration;

/**
 * Class m171209_094844_manage_user
 */
class m171209_094844_manage_user extends Migration
{
    private $_table = '{{%manage_user}}';

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'                   => $this->primaryKey(),
            'email'                => $this->string()->notNull()->unique(),
            'nickname'             => $this->string()->notNull()->defaultValue(""),
            'phone'                => $this->string()->notNull()->defaultValue(""),
            'auth_key'             => $this->string(32)->notNull(),
            'password_hash'        => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'status'               => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at'           => $this->integer(),
            'updated_at'           => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}

