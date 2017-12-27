<?php

namespace common\utils;


class ListGenerator
{
    public static function year()
    {
        $list = range(date("Y"), 1900, -1);

        return array_combine($list, $list);
    }

    public static function month()
    {
        $list = range(1, 12);

        return array_combine($list, $list);
    }

    public static function day()
    {
        $list = range(1, 31);

        return array_combine($list, $list);
    }
}