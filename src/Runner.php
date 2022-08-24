<?php

use DatabaseLoginLoader\DatabaseLoginLoader;

include_once('Database/DatabaseLoginLoader/DatabaseLoginLoader.php');
include_once('Database/DatabaseConnector.php');
include_once('Database/DatabaseDataPrinter.php');
include_once('TerminalReader.php');
include_once('DataLoader/DataLoaderFactory.php');

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
        $dataloader = new DataLoaderFactory();
        $dataloader = $dataloader->getLoaderService('CustomersDatabase', $connection);
        $customerNames = $dataloader->getCustomerNames();

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

        $dataloader = new DataLoaderFactory();
        $dataloader = $dataloader->getLoaderService('CustomersByCityDatabase', $connection, $city);
        $customerNames = $dataloader->getCustomerNames();

        $customers = new DatabaseDataPrinter();
        $customers->printCustomerNames($customerNames);
    }

    /**
     * @throws Exception
     */
    public function runCustomersCsv()
    {
        $dataloader = new DataLoaderFactory();
        $dataloader = $dataloader->getLoaderService('CustomersCSV');
        $customerNames = $dataloader->getCustomerNames();

        $customers = new DatabaseDataPrinter();
        $customers->printCustomerNames($customerNames);
    }
}
