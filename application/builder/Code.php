<?php

namespace application\builder;


use common\models\CodeBlock;
use yii\base\Widget;
use yii\helpers\FileHelper;

class Code extends Widget
{
    // {% block_slug %}
    const INCLUDE_BLOCK_PATTERN = "/{%(.*?)%}/";
    public $blockSlug = "";
    public $params    = [];

    public static function output($blockSlug, $params = [])
    {
        return self::widget([
            'blockSlug' => $blockSlug,
            'params'    => $params,
        ]);
    }

    public function run()
    {
        $file = \Yii::getAlias("@runtime/cache/code_block-" . $this->blockSlug);
        if (!is_file($file)) {
            $content = self::renderWithInclude($this->blockSlug);
            if (!is_dir(dirname($file))) {
                FileHelper::createDirectory(dirname($file));
            }

            file_put_contents($file, $content);
        }

        return $this->renderFile($file, $this->params);
    }

    protected static function renderWithInclude($blockSlug)
    {
        $blockSlug = trim($blockSlug);
        $code      = CodeBlock::getCodeBySlug($blockSlug);
        if (!$code) {
            return "";
        }


        preg_match_all(self::INCLUDE_BLOCK_PATTERN, $code, $machPlaceholder);

        if (empty($machPlaceholder[1])) {
            return $code;
        }

        foreach ($machPlaceholder[1] as $slug) {
            $placeholderItem = "{%" . $slug . "%}";
            $slug            = trim($slug);

            if ($slug == $blockSlug) {
                $code = str_replace($placeholderItem, "", $code);
                continue;
            }

            $slugContent = self::renderWithInclude($slug);
            $code        = str_replace($placeholderItem, $slugContent, $code);
        }

        return $code;
    }
}