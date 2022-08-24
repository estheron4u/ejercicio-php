<?php

include_once('DataLoaderCustomersCSV.php');
include_once('DataLoaderCustomersDatabase.php');
include_once('DataLoaderCustomersByCityDatabase.php');

class DataLoaderFactory
{
    public const CustomersCSV = 'CustomersCSV';
    public const CustomersDatabase = 'CustomersDatabase';
    public const CustomersByCityDatabase = 'CustomersByCityDatabase';

    /**
     * @throws Exception
     */
    public function getLoaderService(string $serviceType, $connection = null, $city = null): DataLoaderInterface
    {
        if ($serviceType === self::CustomersCSV) {
            return new DataLoaderCustomersCSV();
        }
        if ($serviceType === self::CustomersDatabase) {
            return new DataLoaderCustomersDatabase($connection);
        }
        if ($serviceType === self::CustomersByCityDatabase) {
            return new DataLoaderCustomersByCityDatabase($connection, $city);
        }
        throw new Exception('Service non-existent');
    }
}
