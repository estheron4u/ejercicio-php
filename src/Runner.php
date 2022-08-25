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
        $dataloader = $dataloader->getLoaderService('CustomersDatabase');
        $dataloader->setConnection($connection);
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
        $dataloader = $dataloader->getLoaderService('CustomersByCityDatabase');
        $dataloader->setConnection($connection);
        $dataloader->setCity($city);
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

    /**
     * @throws Exception
     */
    public function runCustomersPersonalized()
    {
        $input = new TerminalReader();
        $databasetype = $input->readTerminal('Type desired database type (MySQL or CSV): ');
        if ($databasetype === 'MySQL') {
            $connectortype = $input->readTerminal('Type desired connector type (json or xml): ');
            $connector = $this->getConnector($connectortype);
            $connection = $connector->getDatabaseConnection();

            $dataloader = new DataLoaderFactory();

            $filtering = $input->readTerminal('Filter customers by city? (Yes/No): ');

            if ($filtering === 'Yes') {
                $input = new TerminalReader();
                $city = $input->readTerminal('Insert name of the city you want to view customers from: ');
                $dataloader = $dataloader->getLoaderService('CustomersByCityDatabase');
                $dataloader->setConnection($connection);
                $dataloader->setCity($city);
            } else {
                $dataloader = $dataloader->getLoaderService('CustomersDatabase');
                $dataloader->setConnection($connection);
            }
            $customerNames = $dataloader->getCustomerNames();
        } else {
            $dataloader = new DataLoaderFactory();
            $dataloader = $dataloader->getLoaderService('CustomersCSV');
            $customerNames = $dataloader->getCustomerNames();
        }

        $customers = new DatabaseDataPrinter();
        $customers->printCustomerNames($customerNames);
    }
}
