<?php
class DbConnection
{
    private static PDO $db;
    public static function GetDB(array $config) :PDO
    {
        if(isset(self::$db))
        {
            try {
                self::$db = new PDO($config['dsn'], $config['username'], $config['password'], $config['options']);
            }catch (PDOException $ex)
            {
                echo $ex->getMessage();
            }
        }
        return self::$db;
    }

}