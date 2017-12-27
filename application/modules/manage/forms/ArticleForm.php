<?php

namespace application\modules\manage\forms;

use common\models\Article;
use yii\base\Model;
use yii\web\NotFoundHttpException;

class ArticleForm extends Model
{
    public $id;
    public $type;
    public $title;
    public $slug;
    public $head_image;
    public $category;
    public $description;
    public $keyword;
    public $field;


    /** @var  Article */
    private $articleModel;
    private $_id;

    public function __construct($typeID = null, $id = null)
    {
        $this->_id = $id;
        if ($this->isNewRecord()) {
            $this->articleModel = new Article(['type' => $typeID]);
        } else {
            $this->articleModel = Article::findOne($id);
            if (!$this->articleModel) {
                throw new NotFoundHttpException();
            }
        }

        $this->setAttributes($this->articleModel->getAttributes());
        //$this->articleModel->initFieldData();

        parent::__construct([]);
    }

    public function getArticleModel()
    {
        return $this->articleModel;
    }

    public function isNewRecord()
    {
        return is_null($this->_id);
    }

    public function getTypeID()
    {
        return $this->articleModel->type;
    }

    public function attributeLabels()
    {
        return [
            'email'      => '电子邮箱',
            'password'   => '密码',
            'rememberMe' => '记住我',
            'verifyCode' => '验证码',
        ];
    }

    public function rules()
    {
        return [
            [['title', 'category'], 'required'],
            [['category', 'id', 'type'], 'integer'],
            [['title', 'slug', 'head_image', 'description', 'keyword'], 'string', 'max' => 255],
            [['field'], 'safe'],
        ];
    }

    public function getId()
    {
        return $this->articleModel->primaryKey;
    }

    public function save()
    {
        $trans = \Yii::$app->getDb()->beginTransaction();
        try {
            if (empty($this->slug)) {
                $this->slug = \Yii::$app->getSecurity()->generateRandomString();
            }

            $this->articleModel->setAttributes([
                'title'       => $this->title,
                'type'        => $this->type,
                'slug'        => $this->slug,
                'head_image'  => $this->head_image,
                'category'    => $this->category,
                'keyword'     => $this->keyword,
                'description' => $this->description,
            ]);

            # 更新时不能更新用户ID
            if ($this->isNewRecord()) {
                $this->articleModel->author_id = \Yii::$app->getUser()->getId();
            }

            if (!$this->articleModel->save()) {
                foreach ($this->articleModel->getErrors() as $attribute => $errorString) {
                    $this->addError($attribute, implode("\n", $errorString));
                }
                throw new \Exception("save article fail");
            }

            // save fields
            foreach ($this->field as $fieldName => $fieldData) {
                $model = $this->articleModel->getFieldModel($fieldName);
                $model->setData($this->articleModel->primaryKey, $fieldName, $fieldData);
                $this->articleModel->fieldModels[$fieldName] = $model;

                if (!$model->save()) {
                    foreach ($model->getErrors() as $attribute => $errorString) {
                        $this->addError("field." . $fieldName, implode("\n", $errorString));
                    }
                    throw new \Exception("save content fail");
                }
            }

            $trans->commit();
        } catch (\Exception $e) {
            $trans->rollBack();
            $this->addError(null, $e->getMessage());

            return false;
        }

        return true;
    }
}
