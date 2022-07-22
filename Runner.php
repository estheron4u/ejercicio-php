<?php

include_once('DatabaseLoginLoader.php');
include_once('DatabaseConnector.php');
include_once('DatabaseDataPrinter.php');

class Runner
{
    public function run()
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
}
