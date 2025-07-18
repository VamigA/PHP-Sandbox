<?php

namespace Chat\Util;

use \Chat\Conf;

class Logger
{
    public static function log(object $object, mixed $message): void
    {
        $fileName = PROJECT_ROOT.'/'.Conf::$logsFolder.'/'.date('Y-m-d').'.txt';
        $text = sprintf('[%s][%s] %s'.PHP_EOL, date('H:i:s'), get_class($object), $message);
        file_put_contents($fileName, $text, FILE_APPEND);
    }
}
