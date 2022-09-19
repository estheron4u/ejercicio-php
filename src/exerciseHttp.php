<?php

include_once('Runner.php');

$customers = new Runner();
try {
    $customers->runCustomersPersonalizedFrontend();
} catch (Exception $e) {
    echo 'Exception: ', $e->getMessage();
}

