<?php
//Class Db
//{
//    public static function getConnection()
//    {
//        $paramsPath = ROOT . '/config/db_params.php';
//        $params = include($paramsPath);
//        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
//        $db = new PDO($dsn, $params['user'], $params['password']);
//        $db->exec("SET NAMES utf8");
//        return $db;
//
//    }
//}


Class Db
{

    private static $db;


    public static function getConnection()
    {
        if (!static::$db instanceof PDO) {
            $paramsPath = ROOT . '/config/DbParams.php';
            $params = include($paramsPath);
            $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
            static::$db = new PDO($dsn, $params['user'], $params['password']);
            static::$db->exec("SET NAMES utf8");
        }

        return static::$db;
    }

    /**
     * Db constructor.
     */
    private function __construct()
    {

    }

    private function __wakeup()
    {
        // TODO: Implement __wakeup() method.
    }

    private function __sleep()
    {
        // TODO: Implement __sleep() method.
    }

    private function __clone()
    {

    }


}


?>