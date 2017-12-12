<?php

use yii\db\Migration;

class m170503_162121_category extends Migration
{
    public $_table = '{{%category}}';

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'    => $this->primaryKey(),
            'name'  => $this->string(120)->notNull(),
            'alias' => $this->string(120)->notNull()->defaultValue(""),
            'path'  => $this->string(1200)->notNull()->defaultValue(""),
            'pid'   => $this->integer()->notNull()->defaultValue(0),
            'order' => $this->integer()->notNull()->defaultValue(0),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}
