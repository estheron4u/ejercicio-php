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
    private function getDatabaseCustomers($connection): array
    {
        $dataloader = new DataLoaderFactory();
        $dataloader = $dataloader->getLoaderService('CustomersDatabase'); //FIXME you have a constant for this, remember?
        $dataloader->setConnection($connection);
        return $dataloader->getCustomerNames();
    }

    /**
     * @throws Exception
     */
    private function getDatabaseCustomersByCity($connection): array
    {
        $input = new TerminalReader();
        $city = $input->readTerminal('Insert name of the city you want to view customers from: ');

        $dataloader = new DataLoaderFactory();
        $dataloader = $dataloader->getLoaderService('CustomersByCityDatabase'); //FIXME you have a constant for this, remember?
        $dataloader->setConnection($connection);
        $dataloader->setCity($city);
        return $dataloader->getCustomerNames();
    }

    /**
     * @throws Exception
     */
    public function runCustomers() //TODO did you know that you can also declare 'void' return types? Applies to the next funtions aswell
    {
        $connector = $this->getConnector('xml'); //FIXME you have a constant for this, remember?
        $connection = $connector->getDatabaseConnection();
        $customerNames = $this->getDatabaseCustomers($connection);

        $customers = new DatabaseDataPrinter();
        $customers->printCustomerNames($customerNames);
    }

    /**
     * @throws Exception
     */
    public function runCustomersByCity()
    {
        $connector = $this->getConnector('json'); //FIXME you have a constant for this, remember?
        $connection = $connector->getDatabaseConnection();

        $customerNames = $this->getDatabaseCustomersByCity($connection);

        $customers = new DatabaseDataPrinter();
        $customers->printCustomerNames($customerNames);
    }

    /**
     * @throws Exception
     */
    public function runCustomersCsv()
    {
        $dataloader = new DataLoaderFactory();
        $dataloader = $dataloader->getLoaderService('CustomersCSV'); //FIXME you have a constant for this, remember?
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

        $databasetype = strtolower($input->readTerminal('Type desired database type (MySQL or CSV): ')); // TODO use camelCase: $databaseType
        if ($databasetype === 'mysql') { // FIXME magic string
            $connectortype = strtolower($input->readTerminal('Type desired connector type (json or xml): ')); // TODO use camelCase
            $connector = $this->getConnector($connectortype);
            $connection = $connector->getDatabaseConnection();

            $filtering = strtolower($input->readTerminal('Filter customers by city? (Yes/No): '));

            if ($filtering === 'yes') {
                $customerNames = $this->getDatabaseCustomersByCity($connection);
            } else {  // TODO so... 'potato' also means 'no'?
                $customerNames = $this->getDatabaseCustomers($connection);
            }

            $customers = new DatabaseDataPrinter();
            $customers->printCustomerNames($customerNames);
        } elseif ($databasetype === 'csv'){ //FIXME PSR!
            $this->runCustomersCsv();
        } else {  //TODO this if / elseif / else would be clearer with a 'switch' statement
            throw new Exception('Invalid database type'); // TODO what if I make a typo? should it ask again instead of quitting
        }
    }
}
