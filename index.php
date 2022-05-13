<?php

include('config.php');
include ('GetLoginData.php');
include('GetDatabaseData.php');

$customers = new GetDatabaseData($host, $database);
echo $customers->getCustomers();

