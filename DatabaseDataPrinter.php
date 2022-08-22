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
        if (count(array_column($customerNames, 'customerName')) <= 0) { //TODO PSR!
            throw new Exception("Wrong column key, it must be 'customerName'");
        }
        foreach ($customerNames as $customer) {
            echo "Customer: {$customer['customerName']}\n";
        }
    }

    public function printCustomerNamesCsv()
    {
        $file = fopen("customers.csv", "r");
        while ($csv_line = fgetcsv($file, 1024)) {
            list(, $column2) = $csv_line;
            echo "Customer: $column2\n";
        }
        fclose($file);
    }
}
