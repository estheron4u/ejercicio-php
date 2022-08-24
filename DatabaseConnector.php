<?php

include_once('DatabaseLoginLoader.php');

class DatabaseConnector
{
    private $server;
    private $username;
    private $password;
    private $database;
    private $connection;

    public function __construct($server, $username, $password, $database)
    {
        $this->server = $server;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    /**
     * Only creates a new connection if $connection is empty
     * @throws Exception
     */
    public function getDatabaseConnection(): mysqli
    {
        if ($this->connection === null) {
            $this->connection = new mysqli($this->server, $this->username, $this->password, $this->database);
        }
        if ($this->connection->connect_error) {
            throw new Exception("Connection failed: " . $this->connection->connect_error);
        }
        return $this->connection;
    }
}
