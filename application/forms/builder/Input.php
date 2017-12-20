<?php

namespace application\forms\builder;


use crazydb\ueditor\UEditor;
use yii\bootstrap\InputWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Input extends InputWidget
{
    public $type          = 'textInput';
    public $label         = '';
    public $options       = [];
    public $customOptions = [];
    public $template      = "<div class='form-group'>{label}\n{input}\n{hint}</div>";

    public function run()
    {
        $this->customOptions = $this->mergeOptions();
        return strtr($this->template, [
            '{label}' => $this->getLabelHtml(),
            '{input}' => $this->getInputHtml(),
            '{hint}'  => $this->getHintHtml(),
        ]);
    }

    public function mergeOptions()
    {
        $defaultCustomOptions = $this->defaultCustomOptions();
        return ArrayHelper::merge($defaultCustomOptions, $this->customOptions);
    }

    public function defaultCustomOptions()
    {
        return [
            'rich'  => false,
            'hint'  => "",
            'label' => "",
        ];
    }

    public function getLabelHtml()
    {
        return Html::label($this->customOptions['label'], $this->getId(), ['class' => 'control-label']);
    }

    public function getInputHtml()
    {
        if ($this->customOptions['rich']) {
            return $this->renderRichInput();
        }
        return $this->renderInput();
    }

    private function renderRichInput()
    {
        if ($this->hasModel()) {
            return UEditor::widget([
                'model'     => $this->model,
                'attribute' => $this->attribute,
            ]);
        }

        return UEditor::widget([
            'name'  => $this->name,
            'value' => $this->value,
        ]);
    }

    public function renderInput()
    {
        if (substr($this->type, -4) == "List") {
            return $this->renderListInputHtml($this->type);
        }

        return $this->renderInputHtml($this->type);
    }

    protected function renderListInputHtml($type)
    {
        if ($this->hasModel()) {
            return static::activeListInput($type, $this->model, $this->attribute, $this->options);
        }
        return Html::$type($this->name, $this->value, $this->getDataList(), $this->options);
    }

    /**
     * Generates a list of input fields.
     * This method is mainly called by [[activeListBox()]], [[activeRadioList()]] and [[activeCheckboxList()]].
     *
     * @param string          $type      the input type. This can be 'listBox', 'radioList', or 'checkBoxList'.
     * @param \yii\base\Model $model     the model object
     * @param string          $attribute the attribute name or expression. See [[getAttributeName()]] for the format
     *                                   about attribute expression.
     * @param array           $items     the data item used to generate the input fields.
     *                                   The array keys are the input values, and the array values are the
     *                                   corresponding labels. Note that the labels will NOT be HTML-encoded, while the
     *                                   values will.
     * @param array           $options   options (name => config) for the input list. The supported special options
     *                                   depend on the input type specified by `$type`.
     *
     * @return string the generated input list
     */
    protected static function activeListInput($type, $model, $attribute, $items, $options = [])
    {
        $name      = isset($options['name']) ? $options['name'] : Html::getInputName($model, $attribute);
        $selection = isset($options['value']) ? $options['value'] : Html::getAttributeValue($model, $attribute);
        if (!array_key_exists('unselect', $options)) {
            $options['unselect'] = '';
        }
        if (!array_key_exists('id', $options)) {
            $options['id'] = Html::getInputId($model, $attribute);
        }

        return Html::$type($name, $selection, $items, $options);
    }

    private function getDataList()
    {
        if (is_callable($this->customOptions['dataProvider'])) {
            return call_user_func_array($this->customOptions['dataProvider'], []);
        }

        return $this->customOptions['dataProvider'];
    }

    public function getHintHtml()
    {
        return Html::tag("p", $this->customOptions['hint'], ['class' => 'help-block']);
    }
}