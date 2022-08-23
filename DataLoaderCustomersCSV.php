<?php

class DataLoaderCustomersCSV implements DataLoaderInterface
{
    public function getCustomerNames(): array
    {
        $csv = fopen("customers.csv", "r");
        $customerNames = array();
        $columnKeys = array();
        $i = 0;
        while (($row = fgetcsv($csv, 0, ';')) !== false) {
            if (empty($columnKeys)) {
                $columnKeys = $row;
                continue;
            }
            foreach ($row as $k => $value) {
                $customerNames[$i][$columnKeys[$k]] = $value;
            }
            $i++;
        }
        return $customerNames;
    }
}