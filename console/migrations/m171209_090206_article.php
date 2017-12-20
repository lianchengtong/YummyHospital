<?php

use yii\db\Migration;

class m171209_090206_article extends Migration
{
    private $_table = '{{%article}}';

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'          => $this->primaryKey(),
            'type'        => $this->integer()->notNull(),
            'title'       => $this->string()->notNull()->defaultValue(""),
            'slug'        => $this->string()->notNull()->unique(),
            'head_image'  => $this->string()->notNull()->defaultValue(""),
            'category'    => $this->integer()->notNull(),
            'description' => $this->string()->notNull()->defaultValue(""),
            'keyword'     => $this->string()->notNull()->notNull()->defaultValue(""),
            'author_id'   => $this->integer()->notNull(),
            'created_at'  => $this->integer(),
            'updated_at'  => $this->integer(),
        ]);
    }
}

