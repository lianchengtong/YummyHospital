<?php

namespace application\forms;


use yii\bootstrap\InputWidget;

class Input extends InputWidget
{
    public $options = [
        'rich' => false,
        'type' => "textInput",
    ];

    public function run()
    {
        return $this->renderInputHtml($this->type);
    }
}