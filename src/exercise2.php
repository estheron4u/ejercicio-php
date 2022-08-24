<?php

include_once('Runner.php');

$customersByCity = new Runner();
try {
    $customersByCity->runCustomersByCity();
} catch (Exception $e) {
    echo 'Exception: ', $e->getMessage();
}