<?php
include_once('DatabaseLoginLoader.php');

class DatabaseConnector {

    private $connection;

    public function connectToDatabase(): mysqli {

        $logindata = new DatabaseLoginLoader();
        $server = $logindata->getServer();
        $username = $logindata->getUsername();
        $password = $logindata->getPassword();
        $database = $logindata->getDatabase();

        if ($this->connection == null) { //TODO strict comparison , when viable, makes for a more robust code
            $this->connection = new mysqli($server, $username, $password, $database);
        } else if ($this->connection->connect_error) { //TODO if new mysqli gives error, no exception is thrown. I'll probably split this else into a doble if
            throw new Exception("Connection failed: " . $this->connection->connect_error);
        }
        return $this->connection;
    }
}
