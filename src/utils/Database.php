<?php

namespace Utils;

use PDO;

class Database
{
    private static $connection;

    public static function getConnection()
    {
        if (!self::$connection) {
            $databasePath = '/var/www/html/database/database.sqlite';
            self::$connection = new PDO('sqlite:' . $databasePath);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }
}