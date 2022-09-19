<?php

use DatabaseLoginLoader\DatabaseLoginLoader;

include_once('Database/DatabaseLoginLoader/DatabaseLoginLoader.php');
include_once('Database/DatabaseConnector.php');
include_once('DataLoader/DataLoaderFactory.php');
include_once('FrontendDataPrinter.php');

session_start();
if (isset($_POST['next2'])) {
    $_SESSION['city'] = $_POST['city'];
}

if ($_SESSION['connector'] === 'xml') {
$loginData = new DatabaseLoginLoader(\DatabaseLoginLoader\DatabaseLoginLoaderFactory::XML);
$server = $loginData->getServer();
$username = $loginData->getUsername();
$password = $loginData->getPassword();
$database = $loginData->getDatabase();

$connector = new DatabaseConnector($server, $username, $password, $database);
$connection = $connector->getDatabaseConnection();

$dataLoader = new DataLoaderFactory();
$dataLoader = $dataLoader->getLoaderService($dataLoader::CustomersByCityDatabase);
$dataLoader->setConnection($connection);
$dataLoader->setCity($_SESSION['city']);
$customerNames = $dataLoader->getCustomerNames();

$customers = new FrontendDataPrinter();
?>
<!DOCTYPE html>
<html>
<body>
<h1>Customers from: <?php
    echo $_SESSION['city']; ?></h1>
<ul>
    <?php
    $customers->printCustomerNames($customerNames);
    ?>
</ul>
<?php
} elseif ($_SESSION['connector'] === 'json') {
    $loginData = new DatabaseLoginLoader(\DatabaseLoginLoader\DatabaseLoginLoaderFactory::JSON);
    $server = $loginData->getServer();
    $username = $loginData->getUsername();
    $password = $loginData->getPassword();
    $database = $loginData->getDatabase();

    $connector = new DatabaseConnector($server, $username, $password, $database);
    $connection = $connector->getDatabaseConnection();

    $dataLoader = new DataLoaderFactory();
    $dataLoader = $dataLoader->getLoaderService($dataLoader::CustomersByCityDatabase);
    $dataLoader->setConnection($connection);
    $dataLoader->setCity($_SESSION['city']);
    $customerNames = $dataLoader->getCustomerNames();

    $customers = new FrontendDataPrinter();
    ?>
    <h1>Customers from: <?php
        echo $_SESSION['city']; ?></h1>
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
<p>City: <?php
    echo $_SESSION['city']; ?></p>
<a href="/exerciseHttp.php">Start Again</a>
</body>
</html>