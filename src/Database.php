<?php

namespace Chat;

class Database
{
    private static $pdo = null;

    public static function get(): \PDO
    {
        if (static::$pdo === null)
            static::$pdo = new \PDO(
                'mysql:host='.Conf::$MySQL['host'].';dbname='.Conf::$MySQL['name'],
                Conf::$MySQL['user'],
                Conf::$MySQL['pass'],
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION],
            );

        return static::$pdo;
    }
}
