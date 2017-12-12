<?php

use yii\db\Migration;

/**
 * Class m171209_090655_doctor
 */
class m171209_090655_doctor extends Migration
{
    private $_table = '{{%doctor}}';

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'         => $this->primaryKey(),
            'head_image' => $this->string()->notNull()->defaultValue(""),
            'level'      => $this->integer()->notNull()->defaultValue(1),
            'name'       => $this->string()->notNull(),
            'summary'    => $this->text(),
            'work_time'  => $this->integer(),
            'introduce'  => $this->text(),
            'rank'       => $this->string()->notNull()->defaultValue(0),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}

