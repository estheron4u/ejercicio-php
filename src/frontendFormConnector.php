<?php

include_once('Runner.php');

session_start();

const MYSQL = 'mysql';
const CSV = 'csv';

if (isset($_POST['submitType'])) {
    $_SESSION['type'] = $_POST['type'];
}

if ($_POST['type'] === MYSQL) {
?>

<!DOCTYPE html>
<html>
<body>
<form action="frontendFormFilter.php" method="post" style="
      display: flex;
      flex-direction: column;
      max-width: 200px;
      row-gap: 8px;
">
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
    <input type="submit" name="submitConnector" value="Next"/>
</form>

<?php
} elseif ($_POST['type'] === CSV) {
    $customers = new Runner();
    try {
        $customers->runCustomersCsvFrontend();
    } catch (Exception $e) {
        echo 'Exception: ', $e->getMessage();
    }
}
else {
?>

<!DOCTYPE html>
<html>
<body>
<p>Invalid database type, please try again.</p>

<?php
}
?>
<h2>Here is what you have entered:</h2>
<p>Type: <?php
    echo $_SESSION['type']; ?> </p>
<a href="/exerciseHttp.php">Start Again</a>
</body>
</html>
