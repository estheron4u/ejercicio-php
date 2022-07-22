<?php

include_once('Runner.php');

$customers = new Runner();
try {
    $customers->run();
} catch (Exception $e) {
    echo 'Exception: ', $e->getMessage();
}