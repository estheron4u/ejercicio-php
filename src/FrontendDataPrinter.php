<?php

include_once('Database/DatabaseConnector.php');

class FrontendDataPrinter
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
        if (count(array_column($customerNames, 'customerName')) <= 0) {
            throw new Exception("Wrong column key, it must be 'customerName'");
        }
        foreach ($customerNames as $customer) { ?>
            <li>Customer: <?php echo $customer['customerName'];?></li>
            <?php
        }
    }

}
