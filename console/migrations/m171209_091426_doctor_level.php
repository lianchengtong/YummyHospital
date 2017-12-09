<?php

use yii\db\Migration;

/**
 * Class m171209_091426_doctor_level
 */
class m171209_091426_doctor_level extends Migration
{
    private $_table = '{{%doctor_level}}';

    public function safeUp()
    {
        $this->createTable($this->_table, [
            'id'         => $this->primaryKey(),
            'level_name' => $this->string()->notNull()->defaultValue(""),
        ]);

        $this->batchInsert($this->_table, ['level_name'], [
            ["实习医师"],
            ["住院医师"],
            ["主治医师"],
            ["副主任医师"],
            ["主任医师"],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}

