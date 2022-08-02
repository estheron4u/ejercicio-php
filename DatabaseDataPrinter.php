<?php

include_once('DatabaseConnector.php');

class DatabaseDataPrinter
{
    /**
     * @throws Exception
     */
    public function printCustomerNames($data)
    {
        $customerNames = $data; //TODO no need for so many empty separator lines. Empty lines are considered a code smell

        if (count($customerNames) <= 0) {
            echo "0 results";
            return;
        }

        foreach ($customerNames as $customer) {
            echo "Customer: {$customer['customerName']}\n"; //TODO if 'customerName' does not exist, it will fail. You should check its existence before accessing it. You could also declare the expected structure in the PHPDoc
        }
    }
}
