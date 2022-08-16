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
        $connector = $this->getConnector('login.xml');// TODO suspicious magic string with a filename that probably belongs to
        $customerNames = $connector->getCustomerNames();

        $customers = new DatabaseDataPrinter();
        $customers->printCustomerNames($customerNames);
    }

    /**
     * @throws Exception
     */
    public function runCustomersByCity()
    {
        $input = new TerminalReader();
        $city = $input->readTerminal('Insert name of the city you want to view customers from: ');// TODO maybe you should check connectivity before asking the user for input, as it is frustrating (as a user) to receive an error un related to your input

        $connector = $this->getConnector('login.json');// TODO suspicious magic string with a filename that probably belongs to
        $customerNames = $connector->getCustomerNamesByCity($city);

        $customers = new DatabaseDataPrinter();
        $customers->printCustomerNames($customerNames);
    }
}
