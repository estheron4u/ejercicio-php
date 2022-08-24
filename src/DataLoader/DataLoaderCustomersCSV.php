<?php

include_once('DataLoaderInterface.php');

class DataLoaderCustomersCSV implements DataLoaderInterface
{
    public function getCustomerNames(): array
    {
        $csv = fopen("../customers.csv", "r");
        $customerNames = array();
        $columnKeys = array();
        while (($row = fgetcsv($csv, 0, ';')) !== false) {
            if (empty($columnKeys)) {
                $columnKeys = $row;
                continue;
            }
            $currentRow = [];
            foreach ($row as $columnNumber => $value) {
                $currentRow[$columnKeys[$columnNumber]] = $value;
            }
            $customerNames[] = $currentRow;
        }
        return $customerNames;
    }
}
