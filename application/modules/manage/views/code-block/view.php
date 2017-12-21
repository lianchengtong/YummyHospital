<?= \rogeecn\AceEditor\AceEditor::widget([
    'mode'      => 'php',
    'theme'     => 'github',
    'model'     => $model,
    'attribute' => 'code',
    'readOnly'  => true,
]) ?>
