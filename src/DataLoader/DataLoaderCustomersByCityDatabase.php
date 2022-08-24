<?php

include_once('DataLoaderInterface.php');

class DataLoaderCustomersByCityDatabase implements DataLoaderInterface
{
    private const CUSTOMER_NAMES_QUERY = "SELECT customerName FROM customers WHERE city = ?";
    private $connection;
    private $city;

    public function __construct($connection, $city)
    {
        $this->connection = $connection;
        $this->city = $city;
    }

    /**
     * @throws Exception
     */
    public function getCustomerNames(): array
    {
        $query = self::CUSTOMER_NAMES_QUERY;
        $preparedStatement = $this->connection->prepare($query);
        $preparedStatement->bind_param('s', $this->city);
        $preparedStatement->execute();
        $result = $preparedStatement->get_result();
        $customerNames = [];
        while ($row = $result->fetch_assoc()) {
            $customerNames[] = $row;
        }
        return $customerNames;
    }
}