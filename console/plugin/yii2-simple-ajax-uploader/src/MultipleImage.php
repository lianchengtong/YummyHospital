<?php

namespace rogeecn\SimpleAjaxUploader;


use yii\helpers\Html;

class MultipleImage extends ImageUploaderInput
{
    public  $dropZoneOptions = [
        'class' => 'thumbnail text-center uploader-drop-zone',
        'style' => 'line-height: 120px;',
    ];
    private $containerID;

    protected function callbackComplete()
    {
        $callbackOnComplete = <<<_CODE
function (filename, response, uploadBtn, fileSize){
    $("#{$this->dropZoneOptions['id']}").before('<span class="thumbnail"><img src="'+response.imageUrl+'"></span>');
    
    var imgList = [];
    $("#{$this->containerID} .thumbnail img").each(function(index,item){
         imgList.push($(item).attr("src"))
    }) 
    
    $("#{$this->options['id']}").val(imgList.join(","));
}
_CODE;

        return $callbackOnComplete;
    }

    public function renderImageUploader()
    {
        $value      = $this->model->{$this->attribute};
        $uploadIcon = Html::tag("span", "", [
            'class' => 'glyphicon glyphicon-cloud-upload',
            'style' => 'font-size:52px; margin: 25px 0;',
        ]);
        if (!empty($value)) {
            $value = explode(",", $value);
            foreach ($value as $imageURL) {
                $imgHtml = Html::img($imageURL);
                echo Html::tag("span", $imgHtml, ['class' => 'thumbnail']);
            }
        }
        echo Html::tag("span", $uploadIcon, $this->dropZoneOptions);
    }
}
