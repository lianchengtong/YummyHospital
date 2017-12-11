<?php

use yii\db\Migration;

/**
 * Class m171211_072421_manage_user
 */
class m171211_072421_manage_user extends Migration
{
    private $_table = '{{%manage_user}}';

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'         => $this->primaryKey(),
            'user_id'    => $this->integer()->notNull(),
            'role'       => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}

