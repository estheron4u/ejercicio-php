<?php

include_once('Runner.php');

session_start();
if (isset($_POST['submitConnector'])) {
    $_SESSION['connector'] = $_POST['connector'];
    $_SESSION['filter'] = $_POST['filter'];
}

if ($_POST['filter'] === 'yes') {
?>
<!DOCTYPE html>
<html>
<body>
<form action="frontendFormCity.php" method="post" style="
    display: flex;
    flex-direction: column;
    max-width: 200px;
    row-gap: 8px;
">
    <label for="city">Name of the city you want to filter by: </label>
    <input type="text" name="city">
    <input type="submit" name="submitCity" value="Next"/>
</form>
<?php
} else {
    $customers = new Runner();
    try {
        $customers->runCustomersFrontend();
    } catch (Exception $e) {
        echo 'Exception: ', $e->getMessage();
    }
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