<?php
namespace common\extend;


use yii\base\InvalidConfigException;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

class FormTabs extends \yii\bootstrap\Tabs
{
    public function run()
    {
        ActiveForm::begin();
        echo parent::run();
        ActiveForm::end();
    }

    protected function renderItems()
    {
        $headers = [];
        $panes   = [];

        if (!$this->hasActiveTab()) {
            $this->activateFirstVisibleTab();
        }

        foreach ($this->items as $n => $item) {
            if (!ArrayHelper::remove($item, 'visible', true)) {
                continue;
            }
            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            $encodeLabel   = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $label         = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $headerOptions = array_merge($this->headerOptions, ArrayHelper::getValue($item, 'headerOptions', []));
            $linkOptions   = array_merge($this->linkOptions, ArrayHelper::getValue($item, 'linkOptions', []));

            if (isset($item['items'])) {
                $label .= ' <b class="caret"></b>';
                Html::addCssClass($headerOptions, ['widget' => 'dropdown']);

                if ($this->renderDropdown($n, $item['items'], $panes)) {
                    Html::addCssClass($headerOptions, 'active');
                }

                Html::addCssClass($linkOptions, ['widget' => 'dropdown-toggle']);
                if (!isset($linkOptions['data-toggle'])) {
                    $linkOptions['data-toggle'] = 'dropdown';
                }
                /** @var Widget $dropdownClass */
                $dropdownClass = $this->dropdownClass;
                $header        = Html::a($label, "#", $linkOptions) . "\n"
                                 . $dropdownClass::widget(['items' => $item['items'], 'clientOptions' => false, 'view' => $this->getView()]);
            } else {
                $options       = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
                $options['id'] = ArrayHelper::getValue($options, 'id', $this->options['id'] . '-tab' . $n);

                Html::addCssClass($options, ['widget' => 'tab-pane']);
                if (ArrayHelper::remove($item, 'active')) {
                    Html::addCssClass($options, 'active');
                    Html::addCssClass($headerOptions, 'active');
                }

                if (isset($item['url'])) {
                    $header = Html::a($label, $item['url'], $linkOptions);
                } else {
                    if (!isset($linkOptions['data-toggle'])) {
                        $linkOptions['data-toggle'] = 'tab';
                    }
                    $header = Html::a($label, '#' . $options['id'], $linkOptions);
                }

                if ($this->renderTabContent) {
                    $tag     = ArrayHelper::remove($options, 'tag', 'div');
                    $panes[] = Html::tag($tag, isset($item['content']) ? $item['content'] : '', $options);
                }
            }

            $headers[] = Html::tag('li', $header, $headerOptions);
        }
        $this->options['style'] = "border-bottom: none;";

        $header = Html::tag('ul', implode("\n", $headers), $this->options);
        $panes  = $this->renderPanes($panes);
        $footer = Html::submitButton("提交", ['class' => 'btn btn-primary']);

        $panelHead   = Html::tag("div", $header, ['class' => 'panel-heading', 'style' => 'padding-bottom:0px;']);
        $panelBody   = Html::tag("div", $panes, ['class' => 'panel-body']);
        $panelFooter = Html::tag("div", $footer, ['class' => 'panel-footer text-right']);

        return Html::tag("div", $panelHead . $panelBody . $panelFooter, ['class' => 'panel panel-default']);
    }
}