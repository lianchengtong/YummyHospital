<?php

namespace rogeecn\AceEditor;

use yii\web\AssetBundle;

class AceEditorAsset extends AssetBundle
{
    public $js = [
        'ace.js',
    ];

    public function init()
    {
        parent::init();
        $this->sourcePath = __DIR__ . "/assets";
    }

} 