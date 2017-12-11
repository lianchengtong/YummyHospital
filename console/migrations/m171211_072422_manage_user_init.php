<?php

use yii\db\Migration;

class m171211_072422_manage_user_init extends Migration
{
    private $_table = '{{%user}}';

    public function safeUp()
    {
        $this->insert($this->_table, [
            'nickname'      => 'Rogee',
            'email'         => 'rogeecn@qq.com',
            'phone'         => '18601013734',
            'password_hash' => Yii::$app->security->generatePasswordHash("admin"),
            'auth_key'      => "",
            'created_at'    => time(),
            'updated_at'    => time(),
        ]);

        $this->insert("{{%manage_user}}", [
            'user_id'    => 1,
            'role'       => 0,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    public function safeDown()
    {
    }
}
