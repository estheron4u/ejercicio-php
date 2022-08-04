<?php

include_once('DatabaseLoginLoader.php');
include_once('DatabaseConnector.php');
include_once('DatabaseDataPrinter.php');
include_once('TerminalReader.php');

class Runner
{
    private $server;
    private $username;
    private $password;
    private $database;

    private $connection;

    /**
     * Loads a database connection. Executed only if $connection is empty
     * @return void
     * @throws Exception
     */
    private function loadConnection()
    {
        $logindata = new DatabaseLoginLoader();
        $this->server = $logindata->getServer();
        $this->username = $logindata->getUsername();
        $this->password = $logindata->getPassword();
        $this->database = $logindata->getDatabase();

        $this->connection = new DatabaseConnector();
    }

    public function runCustomers()
    {
        if ($this->connection === null) {
            $this->loadConnection();
        }

        $customerNames = $this->connection->getCustomerNames(
            $this->server,
            $this->username,
            $this->password,
            $this->database
        );

        $customers = new DatabaseDataPrinter();
        $customers->printCustomerNames($customerNames);
    }

    public function runCustomersByCity()
    {
        if ($this->connection === null) {
            $this->loadConnection();
        }

        $input = new TerminalReader();
        $city = $input->readTerminal('Insert name of the city you want to view customers from: ');

        $customerNames = $this->connection->getCustomerNamesByCity(
            $this->server,
            $this->username,
            $this->password,
            $this->database,
            $city
        );

        $customers = new DatabaseDataPrinter();
        $customers->printCustomerNames($customerNames);
    }
}
