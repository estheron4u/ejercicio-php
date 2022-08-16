<?php

include_once('DatabaseLoginLoader.php');
include_once('DatabaseConnector.php');
include_once('DatabaseDataPrinter.php');
include_once('TerminalReader.php');

class Runner
{
    private $connector;

    /**
     * @throws Exception
     */
    private function getConnector($loginfile): DatabaseConnector
    {
        if ($this->connector === null) {
            $logindata = new DatabaseLoginLoader($loginfile);
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
        $connector = $this->getConnector('login.xml');
        $customerNames = $connector->getCustomerNames();

        $customers = new DatabaseDataPrinter();
        $customers->printCustomerNames($customerNames);
    }

    /**
     * @throws Exception
     */
    public function runCustomersByCity()
    {

        $connector = $this->getConnector('login.json');

        $input = new TerminalReader();
        $city = $input->readTerminal('Insert name of the city you want to view customers from: ');

        $customerNames = $connector->getCustomerNamesByCity($city);

        $customers = new DatabaseDataPrinter();
        $customers->printCustomerNames($customerNames);
    }
}
