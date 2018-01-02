<?php

namespace common\models;

use yii\helpers\Url;

/**
 * This is the model class for table "link_group_item".
 *
 * @property integer $id
 * @property integer $link_group_id
 * @property string  $name
 * @property string  $slug
 * @property integer $type
 * @property integer $pid
 * @property integer $order
 * @property string  $data
 * @property string  $options
 */
class LinkGroupItem extends \common\base\ActiveRecord
{
    protected $enableTimeBehavior = false;

    /** @var self[] */
    public $children;

    const TYPE_MODULE  = 0;
    const TYPE_ARTICLE = 1;
    const TYPE_URL     = 2;

    public function rules()
    {
        return [
            [['link_group_id'], 'required'],
            ['slug', 'unique'],
            [['link_group_id', 'order', 'type', 'pid'], 'integer'],
            [['name', 'slug', 'options', 'data'], 'string', 'max' => 255],
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

    public function beforeSave($insert)
    {
        if (empty($this->slug)) {
            $this->slug = md5(\Yii::$app->getSecurity()->generateRandomString());
        }

        return parent::beforeSave($insert);
    }

    public static function getTypeDesc($typeID)
    {
        $list = self::typeList();

        return $list[$typeID];
    }

    public static function getFlatIndentList($groupID, $showRoot = false)
    {
        $list = self::getIndentList($groupID);

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
            $items[$item->pid]->children[$item->id] = &$items[$item->id];

        return isset($items[0]->children) ? $items[0]->children : [];
    }

    public static function getIndentList($groupID)
    {
        $list = self::getList($groupID);

        return self::generateTree($list);
    }

    public static function getList($groupID)
    {
        $dataList = self::find()
                        ->where(['link_group_id' => $groupID])
                        ->orderBy(['pid' => SORT_ASC])
                        ->all();

        $keyDataList = [];
        foreach ($dataList as $data) {
            $keyDataList[$data->primaryKey] = $data;
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
            $items[$item->id] = $prefix . $item->name;
            if (isset($item->children) && is_array($item->children)) {
                self::formatFlatIndentList($item->children, $items, ++$treeLevel);
            }
        }
    }

    public function getOption($optionName = null)
    {
        $optionData = json_decode($this->options, true);
        if (is_null($optionName)) {
            return $optionData;
        }

        return $optionData[$optionName];
    }

    public function getUrl()
    {
        $url = [];
        switch ($this->type) {
            case self::TYPE_ARTICLE:
                $url = ["/article/index", 'id' => $this->data];
                break;
            case self::TYPE_MODULE:
                $url = json_decode($this->data, true);
                break;
            case self::TYPE_URL:
                if (!($url = json_decode($this->data, true))) {
                    $url = $this->data;
                }
                break;
        }

        return Url::to($url);
    }
}