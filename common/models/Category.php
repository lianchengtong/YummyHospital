<?php

namespace common\models;

use common\utils\Cache;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string  $name
 * @property string  $alias
 * @property string  $path
 * @property integer $pid
 * @property integer $order
 */
class Category extends \common\base\ActiveRecord
{
    protected $enableTimeBehavior = false;

    public function rules()
    {
        return [
            [['name', 'alias'], 'required'],
            [['pid', 'order'], 'integer'],
            [['name', 'alias'], 'string', 'max' => 120],
            [['alias'], 'unique'],
            [['path'], 'string', 'max' => 1200],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'    => 'ID',
            'name'  => '名称',
            'alias' => '别名',
            'path'  => '路径',
            'pid'   => '父ID',
        ];
    }

    public static function updatePath()
    {
        self::updateAllPath(self::getIndentList());
    }

    private static function updateAllPath($items = [], $path = [])
    {
        Cache::flush();
        foreach ($items as $item) {
            $tmpPath   = $path;
            $tmpPath[] = $item['id'];
            $pathRoute = implode("-", $tmpPath);

            if ($item['pid'] == 0) {
                self::updateAll(['path' => $pathRoute], ['id' => $item['id']]);
            }

            if (isset($item['children'])) {
                self::updateAllPath($item['children'], $tmpPath);
                continue;
            }

            self::updateAll(['path' => $pathRoute], ['id' => $item['id']]);
        }
    }

    private static function generateTree($items)
    {
        foreach ($items as $item)
            $items[$item['pid']]['children'][$item['id']] = &$items[$item['id']];

        return isset($items[0]['children']) ? $items[0]['children'] : [];
    }

    public static function getIndentList()
    {
        $list = self::getList();

        return self::generateTree($list);
    }

    public static function getList()
    {
        $dataList = Category::find()->orderBy(['pid' => SORT_ASC, 'order' => SORT_ASC])->asArray()->all();

        $keyDataList = [];
        foreach ($dataList as $data) {
            $keyDataList[$data['id']] = $data;
        }

        return $keyDataList;
    }

    private static function formatFlatIndentList($list, &$items = [], $level = 0)
    {
        foreach ($list as $item) {
            $treeLevel = $level;
            $prefix    = "";
            if ($treeLevel > 0) {
                $prefix = str_repeat("- ", $treeLevel * 2);
            }
            $items[$item['id']] = $prefix . $item['name'];
            if (isset($item['children']) && is_array($item['children'])) {
                self::formatFlatIndentList($item['children'], $items, ++$treeLevel);
            }
        }
    }

    public static function getFlatIndentList($showRoot = false)
    {
        $list = self::getIndentList();

        $items = [];
        $level = 0;
        if ($showRoot) {
            $level   = 1;
            $items[] = '根分类';
        }
        self::formatFlatIndentList($list, $items, $level);

        return $items;
    }

    public static function getName($categoryID)
    {
        $model = self::findOne($categoryID);
        if (!$model) {
            return "";
        }

        return $model->name;
    }

    public static function breadCrumb($catID)
    {
        if ($catID == 0) {
            return [];
        }

        $list    = self::getList();
        $catInfo = self::getByID($catID);
        $path    = explode("-", $catInfo['path']);

        $breadcrumbs = [];
        foreach ($path as $catID) {
            $breadcrumbs[] = $list[$catID];
        }

        return $breadcrumbs;
    }

    public static function getSubTree($id, $showFlat = false)
    {
        $list = self::getIndentList();

        $list = self::getSubTreeItems($id, $list);
        if (!$showFlat) {
            return $list;
        }

        $items = [];
        self::formatFlatIndentList([$list], $items);

        return $items;
    }

    private static function getSubTreeItems($id, $list)
    {
        foreach ($list as $item) {
            if ($item['id'] == $id) {
                return $item;
            }

            if (isset($item['children']) && is_array($item['children'])) {
                $ret = self::getSubTreeItems($id, $item['children']);
                if ($ret == false) {
                    continue;
                }

                return $ret;
            }
        }

        return false;
    }

    public static function getByAlias($alias)
    {
        return self::find()->where(['alias' => $alias])->one();
    }

    public static function getByID($id)
    {
        return self::findOne($id);
    }

    // 只会列出直属的分类
    public static function getCategoryChildren($id)
    {
        $categoryList = self::find()->where(['pid' => $id])->orderBy(['order' => SORT_ASC])->all();

        return $categoryList;
    }

    // 所有下属分类,包括孙子节点
    public static function getAllCategoryChildren($id)
    {
        $catInfo      = self::getByID($id);
        $condition    = "path like '" . $catInfo['path'] . "%'";
        $categoryList = self::find()->where($condition)
                            ->orderBy(['order' => SORT_ASC])
                            ->all();

        return $categoryList;

    }

    public static function getSubCategoryIdList($pCategoryID)
    {
        $cacheKey = "category.sub." . $pCategoryID;

        return Cache::dataProvider($cacheKey, function () use ($pCategoryID) {
            $items = self::getSubTree($pCategoryID);

            return $items;
        });
    }
}
