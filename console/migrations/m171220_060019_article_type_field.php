<?php

use yii\db\Migration;

class m171220_060019_article_type_field extends Migration
{
    private $_table = '{{%article_type_field}}';

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'          => $this->primaryKey(),
            'type_id'     => $this->integer()->notNull(),
            'name'        => $this->string()->notNull()->defaultValue(""),
            'description' => $this->string()->notNull()->defaultValue(""),
            'class'       => $this->string()->notNull(),
            'configure'   => $this->string()->notNull()->defaultValue(""),
            'order'       => $this->integer()->notNull()->defaultValue(0),
            'side_show'   => $this->boolean()->notNull()->defaultValue(false),
        ]);
    }
}

