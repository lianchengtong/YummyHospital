<?php

use kartik\file\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */
?>
<h1>Test</h1>

<?php $form = \yii\bootstrap\ActiveForm::begin() ?>
<?= $form->field($model, "key")->widget(FileInput::className(), [
    'options'       => [
        'name'     => 'uploadFile',
        'accept'   => 'images/*',
        'multiple' => true,
    ],
    'pluginOptions' => [
        // 异步上传的接口地址设置
        'uploadUrl'            => Url::to(['@admin/misc/upload']),
        'uploadAsync'          => true,
        // 需要预览的文件格式
        'previewFileType'      => 'image',
        // 预览的文件
        'initialPreview'       => "",
        // 需要展示的图片设置，比如图片的宽度等
        'initialPreviewConfig' => "",
        // 是否展示预览图
        'initialPreviewAsData' => true,
        // 最少上传的文件个数限制
        'minFileCount'         => 3,
        // 最多上传的文件个数限制,需要配置`'multiple'=>true`才生效
        'maxFileCount'         => 10,
        // 是否显示移除按钮，指input上面的移除按钮，非具体图片上的移除按钮
        'showRemove'           => false,
        // 是否显示上传按钮，指input上面的上传按钮，非具体图片上的上传按钮
        'showUpload'           => true,
        //是否显示[选择]按钮,指input上面的[选择]按钮,非具体图片上的上传按钮
        'showBrowse'           => true,
        // 展示图片区域是否可点击选择多文件
        'browseOnZoneClick'    => true,
        // 如果要设置具体图片上的移除、上传和展示按钮，需要设置该选项
        'fileActionSettings'   => [
            // 设置具体图片的查看属性为false,默认为true
            'showZoom'   => true,
            // 设置具体图片的上传属性为true,默认为true
            'showUpload' => true,
            // 设置具体图片的移除属性为true,默认为true
            'showRemove' => true,
        ],
    ],
    //网上很多地方都没详细说明回调触发事件，其实fileupload为上传成功后触发的，三个参数，主要是第二个，有formData，jqXHR以及response参数，上传成功后返回的ajax数据可以在response获取
    'pluginEvents'  => [
        'fileuploaded' => "function (object,data){
    				$('.field-goods-name').show().find('input').val(data.response.imageId);
    			}",
        //错误的冗余机制
        'error'        => "function (){
    				alert('图片上传失败');
    			}",
    ],
]); ?>
<?php \yii\bootstrap\ActiveForm::end(); ?>
