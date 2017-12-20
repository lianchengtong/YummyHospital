<?php

use yii\db\Migration;

class m171220_060009_article_type extends Migration
{
    private $_table = '{{%article_type}}';

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'          => $this->primaryKey(),
            'name'        => $this->string()->notNull()->defaultValue(""),
            'slug'        => $this->string()->notNull()->defaultValue(""),
            'description' => $this->string()->notNull()->unique(),
        ]);
    }
}
