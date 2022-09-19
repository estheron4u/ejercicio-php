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
            $loginData = new DatabaseLoginLoader($serviceType);
            $server = $loginData->getServer();
            $username = $loginData->getUsername();
            $password = $loginData->getPassword();
            $database = $loginData->getDatabase();

            $this->connector = new DatabaseConnector($server, $username, $password, $database);
        }

        return $this->connector;
    }

    /**
     * @throws Exception
     */
    private function getDatabaseCustomers($connection): array
    {
        $dataLoader = new DataLoaderFactory();
        $dataLoader = $dataLoader->getLoaderService($dataLoader::CustomersDatabase);
        $dataLoader->setConnection($connection);
        return $dataLoader->getCustomerNames();
    }

    /**
     * @throws Exception
     */
    private function getDatabaseCustomersByCity($connection): array
    {
        $input = new TerminalReader();
        $city = $input->readTerminal('Insert name of the city you want to view customers from: ');

        $dataLoader = new DataLoaderFactory();
        $dataLoader = $dataLoader->getLoaderService($dataLoader::CustomersByCityDatabase);
        $dataLoader->setConnection($connection);
        $dataLoader->setCity($city);
        return $dataLoader->getCustomerNames();
    }

    /**
     * @throws Exception
     */
    public function runCustomers(): void
    {
        $connector = $this->getConnector(\DatabaseLoginLoader\DatabaseLoginLoaderFactory::XML);
        $connection = $connector->getDatabaseConnection();
        $customerNames = $this->getDatabaseCustomers($connection);

        $customers = new DatabaseDataPrinter();
        $customers->printCustomerNames($customerNames);
    }

    /**
     * @throws Exception
     */
    public function runCustomersByCity(): void
    {
        $connector = $this->getConnector(\DatabaseLoginLoader\DatabaseLoginLoaderFactory::JSON);
        $connection = $connector->getDatabaseConnection();

        $customerNames = $this->getDatabaseCustomersByCity($connection);

        $customers = new DatabaseDataPrinter();
        $customers->printCustomerNames($customerNames);
    }

    /**
     * @throws Exception
     */
    public function runCustomersCsv(): void
    {
        $dataLoader = new DataLoaderFactory();
        $dataLoader = $dataLoader->getLoaderService($dataLoader::CustomersCSV);
        $customerNames = $dataLoader->getCustomerNames();

        $customers = new DatabaseDataPrinter();
        $customers->printCustomerNames($customerNames);
    }

    /**
     * @throws Exception
     */
    public function runCustomersPersonalized(): void
    {
        $input = new TerminalReader();

        $validDatabaseType = false;
        while ($validDatabaseType === false) {
            $databaseType = strtolower($input->readTerminal('Type desired database type (MySQL or CSV): '));
            switch ($databaseType) {
                case 'mysql':
                    $connectorType = strtolower($input->readTerminal('Type desired connector type (json or xml): '));
                    $connector = $this->getConnector($connectorType);
                    $connection = $connector->getDatabaseConnection();

                    $validFilteringType = false;
                    while ($validFilteringType === false) {
                        $filtering = strtolower($input->readTerminal('Filter customers by city? (Yes/No): '));
                        if ($filtering === 'yes') {
                            $customerNames = $this->getDatabaseCustomersByCity($connection);
                            $validFilteringType = true;
                        } elseif ($filtering === 'no') {
                            $customerNames = $this->getDatabaseCustomers($connection);
                            $validFilteringType = true;
                        } else {
                            echo "Invalid answer, please try again\n";
                        }
                    }

                    $customers = new DatabaseDataPrinter();
                    $customers->printCustomerNames($customerNames);
                    $validDatabaseType = true;
                    break;
                case 'csv':
                    $this->runCustomersCsv();
                    $validDatabaseType = true;
                    break;
                default:
                    echo "Invalid database type, please try again\n";
            }
        }
    }
}
