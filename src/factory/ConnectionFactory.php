<?php

namespace iutnc\hellokant\factory;

use PDO;

class ConnectionFactory
{
    public static ?PDO $pdo = null;
    public static function makeConnection(array $conf): PDO
    {
        self::$pdo = new PDO(
            $conf["host"],
            $conf["user"],
            $conf["pass"],
            options: [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_STRINGIFY_FETCHES => false
            ]
        );
        return self::$pdo;
    }

    public static function getConnection(): ?PDO
    {
        if (self::$pdo != null)
            return self::$pdo;
        return null;
    }
}