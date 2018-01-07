<?php
namespace common\extend;


class ActionColumn extends \yii\grid\ActionColumn
{
    public $showDelete = TRUE;
    public $showUpdate = TRUE;
    public $showView   = FALSE;

    public function init()
    {
        parent::init();

        if (!$this->showDelete) {
            $this->template = str_replace("{delete}", "", $this->template);
        }

        if (!$this->showUpdate) {
            $this->template = str_replace("{update}", "", $this->template);
        }

        if (!$this->showView) {
            $this->template = str_replace("{view}", "", $this->template);
        }

        $this->template = trim($this->template);
    }

    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'eye-open',[
            'class'=>'view-btn'
        ]);
        $this->initDefaultButton('update', 'pencil',[
            'class'=>'update-btn'
        ]);
        $this->initDefaultButton('delete', 'trash', [
            'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
            'class'=>'delete-btn'
        ]);
    }
}