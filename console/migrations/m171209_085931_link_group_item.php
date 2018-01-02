<?php

use yii\db\Migration;

class m171209_085931_link_group_item extends Migration
{
    private $_table = '{{%link_group_item}}';

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'            => $this->primaryKey(),
            'link_group_id' => $this->integer()->notNull(),
            'name'          => $this->string()->notNull()->defaultValue(""),
            'slug'          => $this->string()->notNull()->defaultValue(""),
            'type'          => $this->integer()->notNull()->defaultValue(0),
            'pid'           => $this->integer()->notNull()->defaultValue(0),
            'order'         => $this->integer()->notNull()->defaultValue(0),
            'data'          => $this->string()->notNull()->defaultValue(""),
            'options'       => $this->string()->notNull()->defaultValue(""),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}

