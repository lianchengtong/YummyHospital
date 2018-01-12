<?php

namespace common\util;


use Monolog\Handler\PHPConsoleHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;

class Logger
{
    /** @var  \Monolog\Logger[] */
    private static $_logger;

    const BIZ_PAY    = "pay";
    const BIZ_SYSTEM = "system";

    public static function instance($name = self::BIZ_SYSTEM)
    {
        if (!isset(self::$_logger[$name])) {
            $logger = new \Monolog\Logger($name);

            $file_path = sprintf("%s/logs/%s.log", \Yii::getAlias("@runtime"), $name);
            $logger->pushHandler(new RotatingFileHandler($file_path, 7));

            self::$_logger[$name] = $logger;
        }

        return self::$_logger[$name];
    }
}