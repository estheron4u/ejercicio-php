<?php

include_once('DataLoader/DataLoaderFactory.php');
include_once('FrontendDataPrinter.php');

session_start();
if (isset($_POST['next'])) {
    $_SESSION['type'] = $_POST['type'];
}

if ($_POST['type'] === 'mysql') {
?>

<!DOCTYPE html>
<html>
<body>
<form action="frontendFormFilter.php" method="post">
    <label for="connector">Desired connector type: </label>
    <select name="connector">
        <option value="json">json</option>
        <option value="xml">xml</option>
    </select>
    <label for="filter">Do you want to filter the results by city? </label>
    <select name="filter">
        <option value="yes">Yes</option>
        <option value="no">No</option>
    </select>
    <input type="submit" name="next1" value="Next"/>
</form>

<?php
} elseif ($_POST['type'] === 'csv') {
$dataLoader = new DataLoaderFactory();
$dataLoader = $dataLoader->getLoaderService($dataLoader::CustomersCSV);
$customerNames = $dataLoader->getCustomerNames();

$customers = new FrontendDataPrinter();
?>
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
<a href="/exerciseHttp.php">Start Again</a>
</body>
</html>
