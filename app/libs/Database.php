<?php
include_once 'CONFIG.php';

class Database
{
    private static PDO $db;


    private static function getDB(): PDO
    {
        if (!isset(self::$db))
        {
            self::$db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$db;
    }

    public static function query($sql, $params = [], $fetch = false)
    {
        $db = self::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        if ($fetch) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $stmt;
        }
    }
}