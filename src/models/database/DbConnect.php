<?php

namespace application\src\models\database;

/**
 * Represents a database entity.
 */
class DbConnect
{
    
    /**
     * The host of the database.
     */
    private const HOST = "localhost"; // Host of the database

    /**
     * The name of the database.
     */
    private const DBNAME = "OC5"; // Name of the database

    /**
     * The username for accessing the database.
     */
    private const USER = "root"; // Username for accessing the database

    /**
     * The password for accessing the database.
     */
    private const PASSWORD = ""; // Password for accessing the database

    /**
     * The database connection.
     */
    public static $connection; // Database connection

    /**
     * The instance of the database connection.
     */
    private static $instance; // Instance of the database connection

    /**
     * Constructor method.
     */
    private function __construct()
    {
        $this->connect();
    }

    /**
     * Establishes a connection to the database.
     */
    private function connect()
    {
        try {
            if (self::$connection === null) {
                $host = getenv('DB_HOST'); // Host from environment variable
                $dbname = getenv('DB_NAME'); // Database name from environment variable
                $user = getenv('DB_USER'); // Username from environment variable
                $password = getenv('DB_PASSWORD'); // Password from environment variable

                self::$connection = new \PDO("mysql:host=".self::HOST.";dbname=".self::DBNAME, self::USER, self::PASSWORD);
                self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }
        } catch (\PDOException $e) {
            echo "Error when connecting to database.";
        }
    }

    /**
     * Retrieves the instance of the database connection.
     */
    private static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Executes a SQL query.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params The parameters for the query.
     * @return array|false The result of the query or false if there's an error.
     */
    public static function executeQuery($sql, $params = array())
    {
        $db = self::getInstance();
        try {
            $stmt = $db::$connection->prepare($sql);
            foreach ($params as $param => $value) {
                $stmt->bindValue($param, $value, is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
            }
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            echo "Error when executing query : " . $e->getMessage();
            return false;
        }
    }
}
