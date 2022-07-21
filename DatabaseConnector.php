<?php

include_once('DatabaseLoginLoader.php');

class DatabaseConnector
{

    private $connection;

    public function connectToDatabase(): mysqli
    {
        $logindata = new DatabaseLoginLoader();
        $server = $logindata->getServer();
        $username = $logindata->getUsername();
        $password = $logindata->getPassword();
        $database = $logindata->getDatabase();

        if ($this->connection === null) {
            $this->connection = new mysqli($server, $username, $password, $database);
        }
        if ($this->connection->connect_error) {
            throw new Exception("Connection failed: " . $this->connection->connect_error);
        }
        return $this->connection;
    }
}
