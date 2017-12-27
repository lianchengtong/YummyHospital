<?php

namespace application\modules\manage\controllers\misc;

use application\base\AuthRestController;
use common\models\WebsiteConfig;
use common\utils\AliyunOSS;
use common\utils\Request;
use Yii;
use yii\db\Exception;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class UploadController extends AuthRestController
{
    public function actionIndex()
    {
        $config = WebsiteConfig::getMultiValue([
            "storage.mode",
            "storage.file.path",
            "storage.aliyun_oss.domain",
        ]);
        try {
            $instanceName   = Request::input("instance-name");
            $uploadInstance = UploadedFile::getInstanceByName($instanceName);
            $fileID         = md5($uploadInstance->getBaseName());
            $path           = Yii::getAlias($config['storage.file.path']);
            $filePath       = sprintf("%s/%s.%s", date("Y/m/d"), $fileID, $uploadInstance->getExtension());
            $saveFilePath   = sprintf("%s/%s", rtrim($path, "/"), ltrim($filePath, "/"));

            $fileSaveMode = $config['storage.mode'];
            switch ($fileSaveMode) {
                case "file":
                    if (!is_dir(dirname($saveFilePath)) || !is_writable(dirname($saveFilePath))) {
                        FileHelper::createDirectory(dirname($saveFilePath), 0777, true);
                    }

                    if (!$uploadInstance->saveAs($saveFilePath)) {
                        throw new Exception("未知错误");
                    }

                    return [
                        'imageUrl' => str_replace(Yii::getAlias("@application/web"), "", $saveFilePath),
                        'imageId'  => $fileID,
                    ];
                    break;
                case "aliyun_oss":
                    $fileStream = fopen($uploadInstance->tempName, "r");
                    if (!$fileStream) {
                        throw new \Exception("open file stream fail, " . $uploadInstance->tempName);
                    }
                    AliyunOSS::instance()->writeStream($filePath, $fileStream);

                    return [
                        'imageUrl' => sprintf("%s/%s", rtrim($config['storage.aliyun_oss.domain'], "/"), $filePath),
                        'imageId'  => $fileID,
                    ];
                    break;
                default:
                    return ['error' => 'no save mode detect'];
            }
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}