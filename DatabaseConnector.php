<?php

include_once('DatabaseLoginLoader.php');

class DatabaseConnector
{

    private $connection;
//    const CUSTOMER_NAMES_QUERY = "SELECT customerName FROM customers";

    /**
     * @return mysqli
     * @throws Exception
     */
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

    /**
     * @return array
     * @throws Exception
     */
    public function getCustomerNames(): array
    {
        $result = $this->connectToDatabase()->query("SELECT customerName FROM customers");
        $customerNames = [];
        while ($row = $result->fetch_assoc()) {
            $customerNames[] = $row;
        }
        return $customerNames;
    }
}
