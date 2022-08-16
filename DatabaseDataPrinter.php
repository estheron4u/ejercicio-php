<?php

include_once('DatabaseConnector.php');

class DatabaseDataPrinter
{
    /**
     * array column key must be 'customerName'
     * @param array $customerNames
     * @throws Exception
     */
    public function printCustomerNames(array $customerNames)
    {
        if (count($customerNames) <= 0) {
            echo "0 results";
            return;
        }
        if(count(array_column($customerNames,'customerName')) <= 0){ //TODO PSR!
            throw new Exception("Wrong column key, it must be 'customerName'");
        }
        foreach ($customerNames as $customer) {
            echo "Customer: {$customer['customerName']}\n";
        }
    }
}
