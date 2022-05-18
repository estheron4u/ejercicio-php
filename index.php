<?php

include('config.php');
include ('GetLoginData.php');
include('GetDatabaseData.php');

$customers = new GetDatabaseData($host, $database); //TODO GetDatabaseData only works with this database, so does it really need it as a param, or coudlit be a CONST inside the class?
echo $customers->getCustomers(); //TODO getCustomers returns void, there's nothing to echo. Also, if getCustomers() doesn't return a set a customers, it's probably because it's miss-named

