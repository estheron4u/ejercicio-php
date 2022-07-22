<?php

include_once('DatabaseConnector.php');

class DatabaseDataPrinter
{
    /**
     * @throws Exception
     */
    public function printCustomerNames($data)
    {
        $customerNames = $data;

        if (count($customerNames) <= 0) {
            echo "0 results";
            return;
        }

        foreach ($customerNames as $customer) {
            echo "Customer: {$customer['customerName']}\n";
        }
    }
}
