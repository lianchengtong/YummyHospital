<?php

use common\models\DoctorLevel;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Doctor */

$uploadInputName = sprintf("%s[%s]", $model->formName(), "head_image");
?>

<?= $form->field($model, "head_image")->widget(\kartik\file\FileInput::className(), [
    'options'       => [
        'accept'   => 'images/*',
        'multiple' => false,
    ],
    'pluginOptions' => [
        'uploadExtraData'      => [
            'name' => $uploadInputName,
        ],
        // 异步上传的接口地址设置
        'uploadUrl'            => Url::to(['@admin/misc/upload']),
        'uploadAsync'          => true,
        // 需要预览的文件格式
        'previewFileType'      => 'image',
        // 预览的文件
        'initialPreview'       => [$model->head_image],
        // 需要展示的图片设置，比如图片的宽度等
        'initialPreviewConfig' => "",
        // 是否展示预览图
        'initialPreviewAsData' => true,
        // 最少上传的文件个数限制
        'minFileCount'         => 1,
        // 最多上传的文件个数限制,需要配置`'multiple'=>true`才生效
        'maxFileCount'         => 1,
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
        'fileuploaded' => sprintf('function (object,data){$("input[name=\'%s\']:eq(0)").val(data.response.imageUrl)}', $uploadInputName),
    ],
]); ?>

<?= $form->field($model, 'level')->dropDownList(DoctorLevel::levelList()) ?>

<?= $form->field($model, 'name')->textInput() ?>

<?= $form->field($model, 'summary')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'work_time')->textInput() ?>

<?= $form->field($model, 'introduce')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'rank')->textInput(['maxlength' => true]) ?>
