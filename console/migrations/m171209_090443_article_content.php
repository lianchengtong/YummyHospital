<?php

use yii\db\Migration;

class m171209_090443_article_content extends Migration
{
    private $_table = '{{%article_content}}';

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'         => $this->primaryKey(),
            'article_id' => $this->integer()->notNull(),
            'content'    => $this->text(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}

