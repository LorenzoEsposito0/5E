<?php

class DbConfig
{
    private static PDO $db;
    public static function getDB(array $config): PDO{
        if(!isset(self::$db)){
            try{
                self::$db = new PDO($config['dsn'], $config['username'], $config['password'], $config["options"]);
            }catch(PDOException $e){
                logError($e);
                echo "problemi con la connessione al db";
            }
        }
        return self::$db;
    }


}
