<?php

class DataLoaderCustomersCSV implements DataLoaderInterface
{
    public function getCustomerNames(): array
    {
        $csv = fopen("customers.csv", "r");
        $customerNames = array();
        $columnKeys = array();
        $i = 0; //TODO - SEMANTICS: $i is not the best name, how about $rowNumber?
        while (($row = fgetcsv($csv, 0, ';')) !== false) {
            if (empty($columnKeys)) {
                $columnKeys = $row;
                continue;
            }
            foreach ($row as $k => $value) { //TODO - SEMANTICS: $k is not the best name, how about $columnNumber?
                $customerNames[$i][$columnKeys[$k]] = $value;
            }
            $i++; //TODO - SUGGESTION: you could actually avoid this counter by storing all values in a temporal array that is then appended to $customerNames
        }
        return $customerNames;
    }
}
