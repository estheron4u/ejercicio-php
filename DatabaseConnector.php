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
            $connection = new mysqli($server, $username, $password, $database); // Comprobar si ya se ha realizado una conexión a la base de datos antes de realizar una nueva conexión
            if ($connection->connect_error) {
                throw new Exception("Connection failed: " . $connection->connect_error);
            }
            return $connection;
        } catch (Exception $e) { //TODO locally catching a single exception is not better than managing it on the original line - Hacer throws fuera de los try catch y hacer el try solo al final (osea en el index)
            echo 'Exception: ',  $e->getMessage(), "\n";
            return null;
        }
    }
}
