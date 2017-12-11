<?php

use yii\db\Migration;

/**
 * Class m171209_093610_website_config
 */
class m171209_093610_website_config extends Migration
{
    private $_table = '{{%website_config}}';

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'         => $this->primaryKey(),
            'key'        => $this->string()->notNull(),
            'value'      => $this->text(),
            'type'       => $this->string()->notNull()->defaultValue("textInput"),//textInput,
            'const_data' => $this->text(),
            'group_id'   => $this->integer()->notNull()->defaultValue(0),
            'order'      => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}

