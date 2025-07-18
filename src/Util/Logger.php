<?php

namespace Chat\Util;

use \Chat\Conf;


/**
 * Logger class.
 */
class Logger
{
    /**
     * Writes a message to the log file.
     * File: ./Conf::$logsFolder/(Y-m-d).log
     * Message: [(H:i:s)][$object] $message
     *
     * @param object $object Instance of the object that caused the function's call.
     * @param mixed $message Message to the log file.
     */
    public static function log(object $object, mixed $message): void
    {
        $fileName = PROJECT_ROOT.'/'.Conf::$logsFolder.'/'.date('Y-m-d').'.log';
        $text = sprintf('[%s][%s] %s'.PHP_EOL, date('H:i:s'), get_class($object), $message);
        file_put_contents($fileName, $text, FILE_APPEND);
    }
}
