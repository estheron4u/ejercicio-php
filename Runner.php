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
        $database = $logindata->getDatabase();//TODO you have already loaded the XML 8 times by the time you arrive here

        $connection = new DatabaseConnector();
        $data = $connection->getCustomerNames($server, $username, $password, $database); //TODO data applies to almost any variable, try to be more specific

        $customers = new DatabaseDataPrinter();
        $customers->printCustomerNames($data);
    }

    public function runCustomersByCity()
    {
        $logindata = new DatabaseLoginLoader();
        $server = $logindata->getServer();
        $username = $logindata->getUsername();
        $password = $logindata->getPassword();
        $database = $logindata->getDatabase();// TODO I see a lot of duplicated code here

        $input = new TerminalReader();
        $city = $input->readTerminal('Insert name of the city you want to view customers from: '); 

        $connection = new DatabaseConnector();
        $data = $connection->getCustomerNamesByCity($server, $username, $password, $database, $city);

        $customers = new DatabaseDataPrinter();
        $customers->printCustomerNames($data);
    }
}
