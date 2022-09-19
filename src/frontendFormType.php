<?php
session_start ();
?>

<!DOCTYPE html>
<html>
<body>
<form action="frontendFormConnector.php" method="post">
    <label for="type">Desired database type: </label>
    <select name="type">
        <option value="mysql">MySQL</option>
        <option value="csv">CSV</option>
    </select>
    <input type="submit" name="next" value="Next" />
</form>
</body>
</html>
