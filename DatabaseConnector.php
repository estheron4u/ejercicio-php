<?php
include_once('DatabaseLoginLoader.php');

class DatabaseConnector {
    private static $instance = null;

    private $logindata;
    private $server;
    private $username;
    private $password;
    private $database;
    private $connection;

    private function __construct(){
        $this->logindata = new DatabaseLoginLoader();
        $this->server = $this->logindata->getServer();
        $this->username = $this->logindata->getUsername();
        $this->password = $this->logindata->getPassword();
        $this->database = $this->logindata->getDatabase();
        $this->connection = $this->connectToDatabase();
    }

    private function connectToDatabase(){
        try {
            $connection = new mysqli($this->server, $this->username, $this->password, $this->database);
            if ($connection->connect_error) {
                throw new Exception("Connection failed: " . $connection->connect_error);
            }
            return $connection;
        } catch (Exception $e) {
            echo 'Exception: ',  $e->getMessage(), "\n";
            return null;
        }
    }

    public function getConnection(){
        return $this->connection;
    }

    public static function getInstance(){
        if (self::$instance == null){
            self::$instance = new DatabaseConnector();
        }

        return self::$instance;
    }
}