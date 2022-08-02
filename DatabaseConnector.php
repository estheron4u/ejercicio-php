<?php

include_once('DatabaseLoginLoader.php');

class DatabaseConnector
{
    private $connection;
    const CUSTOMER_NAMES_QUERY = "SELECT customerName FROM customers"; // TODO access modifier

    /**
     * @param $server
     * @param $username
     * @param $password
     * @param $database
     * @return mysqli
     * @throws Exception
     */
    public function connectToDatabase($server, $username, $password, $database): mysqli //TODO does not actually always connect, right? I would probably rename it to getDatabaseConnection and explain the cache system on the PHPDoc
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
    public function getCustomerNames($server, $username, $password, $database): array //TODO can this class do anything without $server, $username, $password and $database? No? Then why not get it on the construct and store it as a series of class properties
    {
        $result = $this->connectToDatabase($server, $username, $password, $database)->query(
            self::CUSTOMER_NAMES_QUERY
        );// TODO this line is too long and had to be split. You could probably make it more legible if you use two sentences
        $customerNames = [];
        while ($row = $result->fetch_assoc()) {
            $customerNames[] = $row;
        }
        return $customerNames; //TODO good, way more standard
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
        $query = self::CUSTOMER_NAMES_QUERY . " WHERE city='$city'"; //FIXME this is vulnerable to SQL injection. Never trust user input and always use prepared inputs
        //TODO ';DROP TABLE customers;SELECT '
        $result = $this->connectToDatabase($server, $username, $password, $database)->query(
            $query
        );// TODO this line is too long and had to be split. You could probably make it more legible if you use two sentences
        $customerNames = [];
        while ($row = $result->fetch_assoc()) {
            $customerNames[] = $row;
        }
        return $customerNames;
    }
}
