<?php

include_once('DataLoaderInterface.php');

class DataLoaderCustomersDatabase implements DataLoaderInterface
{
    private const CUSTOMER_NAMES_QUERY = "SELECT customerName FROM customers";
    private $connection;

    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    public function getCustomerNames(): array
    {
        $result = $this->connection->query(self::CUSTOMER_NAMES_QUERY);
        $customerNames = [];
        while ($row = $result->fetch_assoc()) {
            $customerNames[] = $row;
        }
        return $customerNames;
    }
}