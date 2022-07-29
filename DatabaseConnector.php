<?php

include_once('DatabaseLoginLoader.php');

class DatabaseConnector
{
    private $connection;
    const CUSTOMER_NAMES_QUERY = "SELECT customerName FROM customers";

    /**
     * @param $server
     * @param $username
     * @param $password
     * @param $database
     * @return mysqli
     * @throws Exception
     */
    public function connectToDatabase($server, $username, $password, $database): mysqli
    {
        if ($this->connection === null) {
            $this->connection = new mysqli($server, $username, $password, $database);
        }
        if ($this->connection->connect_error) {
            throw new Exception("Connection failed: " . $this->connection->connect_error);
        }
        return $this->connection;
    }

    /**
     * @param $server
     * @param $username
     * @param $password
     * @param $database
     * @return array
     * @throws Exception
     */
    public function getCustomerNames($server, $username, $password, $database): array
    {
        $result = $this->connectToDatabase($server, $username, $password, $database)->query(
            self::CUSTOMER_NAMES_QUERY
        );
        $customerNames = [];
        while ($row = $result->fetch_assoc()) {
            $customerNames[] = $row;
        }
        return $customerNames;
    }

    /**
     * @param $server
     * @param $username
     * @param $password
     * @param $database
     * @param $city
     * @return array
     * @throws Exception
     */
    public function getCustomerNamesByCity($server, $username, $password, $database, $city): array
    {
        $query = self::CUSTOMER_NAMES_QUERY . " WHERE city='$city'";
        $result = $this->connectToDatabase($server, $username, $password, $database)->query(
            $query
        );
        $customerNames = [];
        while ($row = $result->fetch_assoc()) {
            $customerNames[] = $row;
        }
        return $customerNames;
    }
}
