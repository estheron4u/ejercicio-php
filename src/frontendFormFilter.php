<?php

use DatabaseLoginLoader\DatabaseLoginLoader;

include_once('Database/DatabaseLoginLoader/DatabaseLoginLoader.php');
include_once('Database/DatabaseConnector.php');
include_once('DataLoader/DataLoaderFactory.php');
include_once('FrontendDataPrinter.php');

session_start();
if (isset($_POST['next1'])) {
    $_SESSION['connector'] = $_POST['connector'];
    $_SESSION['filter'] = $_POST['filter'];
}

if ($_POST['filter'] === 'yes') {
?>
<!DOCTYPE html>
<html>
<body>
<form action="frontendFormCity.php" method="post">
    <label for="city">Name of the city you want to filter by: </label>
    <input type="text" name="city">
    <input type="submit" name="next2" value="Next"/>
</form>
<?php
} elseif ($_POST['connector'] === 'xml') {
$loginData = new DatabaseLoginLoader(\DatabaseLoginLoader\DatabaseLoginLoaderFactory::XML);
$server = $loginData->getServer();
$username = $loginData->getUsername();
$password = $loginData->getPassword();
$database = $loginData->getDatabase();

$connector = new DatabaseConnector($server, $username, $password, $database);
$connection = $connector->getDatabaseConnection();

$dataLoader = new DataLoaderFactory();
$dataLoader = $dataLoader->getLoaderService($dataLoader::CustomersDatabase);
$dataLoader->setConnection($connection);
$customerNames = $dataLoader->getCustomerNames();

$customers = new FrontendDataPrinter();
?>
<!DOCTYPE html>
<html>
<body>
<h1>Customers:</h1>
<ul>
    <?php
    $customers->printCustomerNames($customerNames);
    ?>
</ul>
<?php
} elseif ($_POST['connector'] === 'json') {
$loginData = new DatabaseLoginLoader(\DatabaseLoginLoader\DatabaseLoginLoaderFactory::JSON);
$server = $loginData->getServer();
$username = $loginData->getUsername();
$password = $loginData->getPassword();
$database = $loginData->getDatabase();

$connector = new DatabaseConnector($server, $username, $password, $database);
$connection = $connector->getDatabaseConnection();

$dataLoader = new DataLoaderFactory();
$dataLoader = $dataLoader->getLoaderService($dataLoader::CustomersDatabase);
$dataLoader->setConnection($connection);
$customerNames = $dataLoader->getCustomerNames();

$customers = new FrontendDataPrinter();
?>
<!DOCTYPE html>
<html>
<body>
<h1>Customers:</h1>
<ul>
    <?php
    $customers->printCustomerNames($customerNames);
    ?>
</ul>
<?php
}
?>

<h2>Here is what you have entered:</h2>
<p>Type: <?php
    echo $_SESSION['type']; ?> </p>
<p>Connector: <?php
    echo $_SESSION['connector']; ?></p>
<p>Filter: <?php
    echo $_SESSION['filter']; ?></p>
<a href="/exerciseHttp.php">Start Again</a>
</body>
</html>