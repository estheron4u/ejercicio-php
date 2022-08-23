<?php

include_once('DatabaseLoginLoader.php');
include_once('DatabaseConnector.php');
include_once('DatabaseDataPrinter.php');
include_once('TerminalReader.php');
include_once('DataLoaderCustomersDatabase.php');
include_once('DataLoaderCustomersByCityDatabase.php');
include_once('DataLoaderCustomersCSV.php');

class Runner
{
    private $connector;

    /**
     * @throws Exception
     */
    private function getConnector($serviceType): DatabaseConnector
    {
        if ($this->connector === null) {
            $logindata = new DatabaseLoginLoader($serviceType);
            $server = $logindata->getServer();
            $username = $logindata->getUsername();
            $password = $logindata->getPassword();
            $database = $logindata->getDatabase();

            $this->connector = new DatabaseConnector($server, $username, $password, $database);
        }

        return $this->connector;
    }

    /**
     * @throws Exception
     */
    public function runCustomers()
    {
        $connector = $this->getConnector('xml');
        $connection = $connector->getDatabaseConnection();
        $customerNames = new DataLoaderCustomersDatabase($connection);
        $customerNames = $customerNames->getCustomerNames();

        $customers = new DatabaseDataPrinter();
        $customers->printCustomerNames($customerNames);
    }

    /**
     * @throws Exception
     */
    public function runCustomersByCity()
    {
        $connector = $this->getConnector('json');
        $connection = $connector->getDatabaseConnection();

        $input = new TerminalReader();
        $city = $input->readTerminal('Insert name of the city you want to view customers from: ');

        $customerNames = new DataLoaderCustomersByCityDatabase($connection, $city);
        $customerNames = $customerNames->getCustomerNames();

        $customers = new DatabaseDataPrinter();
        $customers->printCustomerNames($customerNames);
    }

    /**
     * @throws Exception
     */
    public function runCustomersCsv()
    {
        $customerNames = new DataLoaderCustomersCSV();
        $customerNames = $customerNames->getCustomerNames();

        $customers = new DatabaseDataPrinter();
        $customers->printCustomerNames($customerNames);
    }
}
