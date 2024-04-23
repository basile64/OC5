<?php

namespace application\src\models\database;

class DbConnect
{
    private const HOST = "localhost";
    private const DBNAME = "OC5";
    private const USER = "root";
    private const PASSWORD = "";
    public static $connection;
    private static $instance;

    private function __construct(){
        $this->connect();
    }

    private function connect(){
        try {
            if (self::$connection === null){
                self::$connection = new \PDO("mysql:host=".self::HOST.";dbname=".self::DBNAME, self::USER, self::PASSWORD);
                self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }
        } catch (\PDOException $e) {
            echo "Error when connecting to database.";
        }

    }

    private static function getInstance(){
        if (self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function executeQuery($sql, $params = array()){
        $db = self::getInstance();
        try {
            $stmt = $db::$connection->prepare($sql);
            foreach($params as $param=>$value){
                $stmt->bindValue($param, $value, is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
            }
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;

        } catch (\PDOException $e) {
            echo "Error when executing query : ". $e->getMessage();
            return false;
        }
    }

}
