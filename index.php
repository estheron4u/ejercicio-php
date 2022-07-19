<?php
include_once('DatabaseDataPrinter.php');

$customers = new DatabaseDataPrinter();
try {
    $customers->printCustomerNames();
} catch (Exception $e){
    echo 'Exception: ',  $e->getMessage();
}
