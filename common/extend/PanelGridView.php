<?php
namespace common\extend;

use yii\grid\GridView;

class PanelGridView extends GridView
{
    public $buttons = [];

    public function init()
    {
        Html::addCssClass($this->options, 'panel panel-default');

        $headingButtons = implode("\n", $this->buttons);
        $this->layout   = <<<_CODE
<div class="panel-heading clearfix">
    <div class="pull-right">
         $headingButtons
    </div>
</div>
{items}
<div class="panel-footer clearfix">
    <div class="pull-left">
        {summary}
    </div>
    
    <div class="pull-right">
        {pager}
    </div>
</div>
_CODE;

        parent::init();
    }
}
