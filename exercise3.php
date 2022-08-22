<?php

include_once('Runner.php');

$customers = new Runner();
try {
    $customers->runCustomersCsv();
} catch (Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
