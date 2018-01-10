<?php

use yii\db\Migration;

class m180110_134632_alter_member_own_card extends Migration
{
    private $_table = '{{%member_own_card}}';

    public function safeDown()
    {
        $this->dropColumn($this->_table, "card_id");
    }

    public function safeUp()
    {
        $this->addColumn($this->_table, "card_id",
            $this->integer()->notNull()->after("id")
        );
    }
}

