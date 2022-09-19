<?php

include_once('Runner.php');

session_start();
if (isset($_POST['submitCity'])) {
    $_SESSION['city'] = $_POST['city'];
}
$customers = new Runner();
try {
    $customers->runCustomersByCityFrontend();
} catch (Exception $e) {
    echo 'Exception: ', $e->getMessage();
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