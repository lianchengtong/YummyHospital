<?php

namespace rogeecn\SimpleAjaxImageUploader;


use yii\helpers\Html;
use yii\web\View;
use yii\widgets\InputWidget;

class UploaderInput extends InputWidget
{
    public $action  = "/plugin/uploader";
    public $wrapper = "uploader";

    /**
     * @var array
     * - limitCount
     * -
     */
    public $options        = [];
    public $defaultOptions = [
        'limitCount'    => 1,
        'fileType'      => 'images',  // images,file,video,audio
        'handleSuccess' => '',
    ];

    public $template = "<ul class='image-upload'><li class='upload-wrapper'>{input}</li>\n{image}</ul>";


    public function init()
    {
        $this->options = array_merge($this->defaultOptions, $this->options);
        if (empty($this->options['showText'])) {
            $this->options['showText'] = Html::tag("span", '', [
                'class' => "glyphicon glyphicon-upload",
                'style' => "cursor:pointer",
            ]);
        }

        UploaderAssets::register($this->getView());
        $this->getView()->registerJs($this->getJs(), View::POS_READY);
        $this->getView()->registerCss($this->getCSS());

    }

    private function getJs()
    {
        if (empty($this->options['handleSuccess'])) {
            $this->options['handleSuccess'] = <<<_JS_SUCCESS_
function(files,data,xhr,pd){
    var _html_tpl = '<li>';
    _html_tpl += '<span class="remove">删除</span>';
    _html_tpl += '<img src="{$this->options['sourceURL']}_IMG_PATH_"/>';
    _html_tpl += '<input type=hidden name="{$this->name}[]" value="{$this->options['sourceURL']}_IMG_PATH_"/>';
    _html_tpl += '</li>';
    
    
    var data = JSON.parse(data);
    console.log(data,files); 
    
    
    var htmlList  ="";
    data.forEach(function(fileData){
        var html = _html_tpl.replace("_IMG_PATH_",fileData)
        htmlList += html.replace("_IMG_PATH_",fileData)
    })
    console.log(htmlList); 
    
    $(".image-upload").append(htmlList);
}
_JS_SUCCESS_;
        }


        $js = <<<_JS_
$("#{$this->wrapper}").uploadFile({
    url:"/plugin/uploader",
    fileName:"ajax-file-upload",
    showPreview: true,
    showFileSize: true,
    showFileSize: true,
    showDelete: true,
    dragDropStr: "",
    uploadStr: '{$this->options['showText']}',
    previewWidth: 100,
    dragdropWidth: 100,
    previewHeight: 100,
    maxFileCount: {$this->options['limitCount']},
    onSuccess: {$this->options['handleSuccess']},
}); 

$("body").on("click","ul.image-upload span.remove",function(data){
    if (!confirm("确认删除图片么?")){
         return;
    }
    
    $(this).closest("li").remove();
});
_JS_;

        return $js;
    }

    private function getCSS()
    {
        $css = <<<_CSS
    .ajax-file-upload-container{display: none;}
    .ajax-file-upload{
        height: 100px;
        padding: 20px 0;
        text-align: center;
        font-size: 40px;
    }
    ul.image-upload{
        border: 1px solid #e6e6e6;
        padding: 0px;
    }
    ul.image-upload > li {
        display: inline-block;
        position: relative;
        margin: 10px;
        width: 100px;
        height: 100px;
        border: 1px solid #e6e6e6;
        vertical-align: top;
        padding: 1px;
    }

    ul.image-upload > li img {
        width: 100%;
        height: 100%;
    }

    ul.image-upload > li .layui-upload-button {
        width: 100%;
        height: 100%;
    }
    
    ul.image-upload > li .remove {
        position: absolute;
        bottom: 1px;
        background: #ff5722;
        display: block;
        width: 96px;
        opacity: 0.6;
        height: 20px;
        line-height: 20px;
        font-size: 12px;
        text-align: center;
        color: white;
        cursor: pointer;
    }

    ul.image-upload > li .remove:hover {
        opacity: 0.8;
    }
_CSS;

        return $css;
    }

    public function run()
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = self::getId();
        }

        $imageList = is_array($this->value) ? $this->value : explode(",", $this->value);
        $imageList = array_filter($imageList);

        $liList = [];
        foreach ($imageList as $image) {
            if (strpos($image, "http") === 0) {
                $imageURL = $image;
            } elseif (strpos($image, "//") === 0) {
                $imageURL = $image;
            } else {
                $imageURL = $this->options['sourceURL'] . ltrim($image, "/");
            }
            $removeBtn = Html::tag("span", "删除", ['class' => ['remove']]);
            $image     = Html::img($imageURL);
            $input     = Html::hiddenInput($this->name . "[]", $imageURL);
            $liList[]  = Html::tag("li", $removeBtn . $image . $input);
        }

        return strtr($this->template, [
            "{input}" => Html::tag("div", "", ['id' => $this->wrapper]),
            "{image}" => implode("\n", $liList),
        ]);
    }
}