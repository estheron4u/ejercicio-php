<?php

include_once('DatabaseLoginLoader.php');
include_once('DatabaseConnector.php');
include_once('DatabaseDataPrinter.php');
include_once('TerminalReader.php');

class Runner
{
    public function runCustomers()
    {
        $logindata = new DatabaseLoginLoader();
        $server = $logindata->getServer();
        $username = $logindata->getUsername();
        $password = $logindata->getPassword();
        $database = $logindata->getDatabase();

        $connection = new DatabaseConnector();
        $data = $connection->getCustomerNames($server, $username, $password, $database);

        $customers = new DatabaseDataPrinter();
        $customers->printCustomerNames($data);
    }

    public function runCustomersByCity()
    {
        $logindata = new DatabaseLoginLoader();
        $server = $logindata->getServer();
        $username = $logindata->getUsername();
        $password = $logindata->getPassword();
        $database = $logindata->getDatabase();

        $input = new TerminalReader();
        $city = $input->readTerminal('City: ');

        $connection = new DatabaseConnector();
        $data = $connection->getCustomerNamesByCity($server, $username, $password, $database, $city);

        $customers = new DatabaseDataPrinter();
        $customers->printCustomerNames($data);
    }
}
