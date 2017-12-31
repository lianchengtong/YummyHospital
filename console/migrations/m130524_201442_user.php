<?php

use yii\db\Migration;

class m130524_201442_user extends Migration
{
    private $_table = '{{%user}}';

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'                   => $this->primaryKey(),
            'phone'                => $this->string()->notNull()->defaultValue(""),
            'email'                => $this->string()->notNull()->defaultValue(""),
            'head_image'           => $this->string()->notNull()->defaultValue(""),
            'nickname'             => $this->string()->notNull()->defaultValue(""),
            'auth_key'             => $this->string(32)->notNull(),
            'password_hash'        => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'status'               => $this->smallInteger()->notNull()->defaultValue(\common\models\User::STATUS_ACTIVE),
            'created_at'           => $this->integer(),
            'updated_at'           => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}
