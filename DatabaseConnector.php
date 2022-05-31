<?php
include_once('DatabaseLoginLoader.php');

class DatabaseConnector {

    public static function connectToDatabase() {

        $logindata = new DatabaseLoginLoader();
        $server = $logindata->getServer();
        $username = $logindata->getUsername();
        $password = $logindata->getPassword();
        $database = $logindata->getDatabase();

        try {
            $connection = new mysqli($server, $username, $password, $database);
            if ($connection->connect_error) {
                throw new Exception("Connection failed: " . $connection->connect_error);
            }
            return $connection;
        } catch (Exception $e) {
            echo 'Exception: ',  $e->getMessage(), "\n";
            return null;
        }
    }
}
