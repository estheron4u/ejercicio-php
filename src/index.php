<?php

include_once('Runner.php');

$customers = new Runner();
try {
    $customers->runCustomers();
} catch (Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
