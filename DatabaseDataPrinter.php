<?php
include_once('DatabaseConnector.php');

class DatabaseDataPrinter{
    const CUSTOMER_NAMES_QUERY = "SELECT customerName FROM customers"; //TODO why does a 'printer' speak SQL?

    public function printCustomerNames(){ //TODO it actually does way more than print them, right? Why not make a Runner class which makes as an intermediary between the 'CredentialLoader', 'DatabaseConnector' and 'Printer'?
        $connection = new DatabaseConnector();
        $result = $connection->connectToDatabase()->query(self::CUSTOMER_NAMES_QUERY);

        if ($result->num_rows <= 0) {
            echo "0 results";
            return;
        }
        while($row = $result->fetch_assoc()) {
            echo "Customer: {$row['customerName']}\n";
        }
    }

}
