<?php

class MysqliWrapper {
    private static $host = 'localhost';
    private static $user = 'root';
    private static $pass = 'pass';
    private static $db = 'stars';

    public static function getMysqli() {
        return new mysqli(self::$host, self::$user, self::$pass, self::$db);
    }

}