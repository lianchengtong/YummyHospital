<?php

namespace application\modules\manage\forms;

use common\models\Article;
use common\models\ArticleContent;
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
    public $content;

    /** @var  Article */
    private $articleModel;
    private $_id;

    public function __construct($id = null)
    {
        $this->_id = $id;
        if ($this->isNewRecord()) {
            $this->articleModel = new Article();
        } else {
            $this->articleModel = Article::findOne($id);
            if (!$this->articleModel) {
                throw new NotFoundHttpException();
            }
        }

        parent::__construct([]);
    }

    public function isNewRecord()
    {
        return is_null($this->_id);
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
            [['category'], 'integer'],
            [['title', 'content', 'slug', 'head_image', 'description', 'keyword'], 'string', 'max' => 255],
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

            /** @var ArticleContent $contentModel */
            if ($this->isNewRecord()) {
                $contentModel             = new ArticleContent();
                $contentModel->article_id = $this->articleModel->primaryKey;
            } else {
                $contentModel = $this->articleModel->content;
            }
            $contentModel->content = $this->content;

            if (!$contentModel->save()) {
                foreach ($contentModel->getErrors() as $attribute => $errorString) {
                    $this->addError("content." . $attribute, implode("\n", $errorString));
                }
                throw new \Exception("save content fail");
            }


            $trans->commit();
        } catch (\Exception $e) {
            $trans->rollBack();

            return false;
        }

        return true;
    }
}
