<?php
namespace common\extend;

use yii\grid\GridView;

class PanelGridView extends GridView
{
    public $buttons = [];

    public function init()
    {
        Html::addCssClass($this->options, 'panel panel-default');

        //if ($this->dataProvider->getTotalCount() == 0) {
        //    $this->filterModel = NULL;
        //}

        $headingButtons = implode("\n", $this->buttons);
        $panelHeading   = <<<_CODE_HEAD
<div class="panel-heading clearfix">
    <div class="pull-right">
         $headingButtons
    </div>
</div>
_CODE_HEAD;
        if (empty($this->buttons)) {
            $panelHeading = "";
        }

        $this->layout = <<<_CODE
$panelHeading
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

    public function renderTableHeader()
    {
        $head = parent::renderTableHeader();

        return strtr($head, [
            "<thead>"              => "<thead style='background: #f5f5f5'>",
            'class="form-control"' => 'class="form-control input-sm"',
        ]);
    }
}
