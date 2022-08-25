<?php

include_once('Runner.php');

$customers = new Runner();
try {
    $customers->runCustomersPersonalized();
} catch (Exception $e) {
    echo 'Exception: ', $e->getMessage();
}

