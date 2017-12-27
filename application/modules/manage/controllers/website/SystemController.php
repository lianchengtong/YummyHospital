<?php

namespace application\modules\manage\controllers\website;

use application\base\AuthController;
use common\models\ArticleType;
use common\models\ArticleTypeField;
use common\models\Category;
use common\models\CodeBlock;
use common\models\Department;
use common\models\DoctorLevel;
use common\models\LinkGroup;
use common\models\LinkGroupItem;
use common\models\WebsiteConfig;
use common\models\WebsiteConfigGroup;
use common\utils\Request;
use yii\base\Exception;
use yii\web\UploadedFile;

class SystemController extends AuthController
{
    public function actionIndex()
    {
        $errMsg      = "";
        $restoreInfo = [];
        if (Request::isPost()) {
            $fileInstance = UploadedFile::getInstanceByName("backup");
            try {
                if (!$fileInstance) {
                    throw new Exception("请选择上传文件！");
                }

                $content     = file_get_contents($fileInstance->tempName);
                $contentData = json_decode($content, true);

                foreach ($contentData as $className => $dataItems) {
                    foreach ($dataItems as $dataItem) {
                        $model = $className::findOne($dataItem['id']);
                        if (!$model) {
                            $model = new $className();
                        }

                        $model->setAttributes($dataItem);
                        if ($model->save()) {
                            $restoreInfo[] = sprintf("[SUCCESS] Table: %s, DATA: %s",
                                $className::tableName(),
                                json_encode($dataItem, JSON_UNESCAPED_UNICODE)
                            );
                            continue;
                        }
                        $restoreInfo[] = sprintf("[FAIL] Table: %s, DATA: %s, ERROR: %s",
                            $className::tableName(),
                            json_encode($dataItem, JSON_UNESCAPED_UNICODE),
                            json_encode($model->getErrors(), JSON_UNESCAPED_UNICODE)
                        );
                    }
                }
            } catch (\Exception $e) {
                $errMsg = $e->getMessage();
            }
        }
        return $this->render("index", [
            'errmsg'      => $errMsg,
            'restoreInfo' => $restoreInfo,
        ]);
    }

    public function actionBackup()
    {
        $db = [
            CodeBlock::className(),
            WebsiteConfigGroup::className(),
            WebsiteConfig::className(),
            ArticleType::className(),
            ArticleTypeField::className(),
            LinkGroup::className(),
            LinkGroupItem::className(),
            Category::className(),
            Department::className(),
            DoctorLevel::className(),
        ];

        $backupData = [];
        foreach ($db as $dbClass) {
            $allData              = $dbClass::find()->asArray()->all();
            $backupData[$dbClass] = $allData;
        }

        $data     = json_encode($backupData);
        $fileName = sprintf("backup%s.bak", date("YmdHis"));
        \Yii::$app->getResponse()->sendContentAsFile($data, $fileName);
    }
}
