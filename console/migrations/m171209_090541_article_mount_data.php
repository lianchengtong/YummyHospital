<?php

use yii\db\Migration;

/**
 * Class m171209_090541_article_mount_data
 */
class m171209_090541_article_mount_data extends Migration
{
    private $_table = '{{%article_mount_data}}';

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'         => $this->primaryKey(),
            'article_id' => $this->integer()->notNull(),
            'tag'        => $this->string()->notNull(),
            'data'       => $this->text(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}

