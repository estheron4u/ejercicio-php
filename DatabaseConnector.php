<?php

include_once('DatabaseLoginLoader.php');

class DatabaseConnector
{
//    private const CUSTOMER_NAMES_QUERY = "SELECT customerName FROM customers"; //TODO - BAD PRACTICE: yuo have git to recover past code, no need to preserve it commented
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
    //TODO - BAD PRACTICE: yuo have git to recover past code, no need to preserve it commented
//
//    /**
//     * @throws Exception
//     */
//    public function getCustomerNames(): array
//    {
//        $connection = $this->getDatabaseConnection();
//        $result = $connection->query(self::CUSTOMER_NAMES_QUERY);
//        $customerNames = [];
//        while ($row = $result->fetch_assoc()) {
//            $customerNames[] = $row;
//        }
//        return $customerNames;
//    }

//    /**
//     * @throws Exception
//     */
//    public function getCustomerNamesByCity($city): array
//    {
//        $query = self::CUSTOMER_NAMES_QUERY . " WHERE city = ?";
//        $connection = $this->getDatabaseConnection();
//        $preparedStatement = $connection->prepare($query);
//        $preparedStatement->bind_param('s', $city);
//        $preparedStatement->execute();
//        $result = $preparedStatement->get_result();
//        $customerNames = [];
//        while ($row = $result->fetch_assoc()) {
//            $customerNames[] = $row;
//        }
//        return $customerNames;
//    }
}
