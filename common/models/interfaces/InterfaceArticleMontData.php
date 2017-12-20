<?php

namespace common\models\interfaces;


interface InterfaceArticleMontData
{
    public static function getModel($tagName, $articleID);

    public function getFieldName();

    public function getData();

    public function setData($articleID, $tag, $data);
}