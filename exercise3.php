<?php

include_once('Runner.php');

$customers = new Runner();
try {
    $customers->runCustomersCsv();
} catch (Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
//TODO - SUGGESTION: you now have about 16 files with code + config files + the README. It would probably be a good time to start classifying everything in folders
