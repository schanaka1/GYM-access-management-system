<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Database
{
    private static $dbName = 'id21900375_gymnsb';
    private static $dbHost = 'localhost';
    private static $dbUsername = 'id21900375_root';
    private static $dbUserPassword = 'Database1234#';

    private static $cont = null;

    public function __construct()
    {
        die('Init function is not allowed');
    }

    public static function connect()
    {
        // One connection through whole application
        if (null == self::$cont) {
            try {
                self::$cont = new PDO("mysql:host=" . self::$dbHost . ";" . "dbname=" . self::$dbName, self::$dbUsername, self::$dbUserPassword);
                $conn = self::$cont; // Assign the PDO connection to $conn variable
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        return $conn;
    }

    public static function disconnect()
    {
        self::$cont = null;
    }
}
?>
