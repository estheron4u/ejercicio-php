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
     * @param string $serviceType
     * @return DataLoaderCustomersByCityDatabase|DataLoaderCustomersCSV|DataLoaderCustomersDatabase
     * @throws Exception
     */
    public function getLoaderService(string $serviceType)
    {
        if ($serviceType === self::CustomersCSV) {
            return new DataLoaderCustomersCSV();
        }
        if ($serviceType === self::CustomersDatabase) {
            return new DataLoaderCustomersDatabase();
        }
        if ($serviceType === self::CustomersByCityDatabase) {
            return new DataLoaderCustomersByCityDatabase();
        }
        throw new Exception('Service non-existent');
    }
}
