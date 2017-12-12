<?php

namespace common\models;

/**
 * This is the model class for table "link_group_item".
 *
 * @property integer $id
 * @property integer $link_group_id
 * @property string  $name
 * @property string  $slug
 * @property integer $type
 * @property integer $pid
 * @property string  $data
 */
class LinkGroupItem extends \common\base\ActiveRecord
{
    protected $enableTimeBehavior = FALSE;

    const TYPE_MODULE  = 0;
    const TYPE_ARTICLE = 1;
    const TYPE_URL     = 2;

    public function rules()
    {
        return [
            [['link_group_id'], 'required'],
            ['slug', 'unique'],
            [['link_group_id', 'order', 'type', 'pid'], 'integer'],
            [['name', 'slug', 'data'], 'string', 'max' => 255],
            ['order', 'default', 'value' => 0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'link_group_id' => 'Link Group ID',
            'name'          => 'Name',
            'slug'          => 'Slug',
            'type'          => 'Type',
            'pid'           => 'Pid',
            'data'          => 'Data',
            'order'         => 'Order',
        ];
    }

    public static function typeList()
    {
        return [
            self::TYPE_MODULE  => '模块',
            self::TYPE_ARTICLE => '文章',
            self::TYPE_URL     => 'URL',
        ];
    }

    public static function getTypeDesc($typeID)
    {
        $list = self::typeList();

        return $list[$typeID];
    }

    public static function getFlatIndentList($showRoot = FALSE)
    {
        $list = self::getIndentList();

        $items = [];
        $level = 0;
        if ($showRoot) {
            $level   = 1;
            $items[] = '------------------';
        }
        self::formatFlatIndentList($list, $items, $level);

        return $items;
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
        $dataList = self::find()->orderBy(['pid' => SORT_ASC])->asArray()->all();

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
}
