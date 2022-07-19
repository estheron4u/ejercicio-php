<?php
include_once('DatabaseConnector.php');

class DatabaseDataPrinter{
    const CUSTOMER_NAMES_QUERY = "SELECT customerName FROM customers";

    public function printCustomerNames(){
        $connection = new DatabaseConnector();
        $result = $connection->connectToDatabase()->query(self::CUSTOMER_NAMES_QUERY);

        if ($result->num_rows <= 0) {
            echo "0 results";
        } else {
            while($row = $result->fetch_assoc()) {
                echo "Customer: {$row['customerName']}\n";
            }
        }
    }

}
