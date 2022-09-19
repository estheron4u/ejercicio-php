<?php
session_start ();
?>

<!DOCTYPE html>
<html>
<body>
<form action="frontendFormConnector.php" method="post" style="
    display: flex;
    flex-direction: column;
    max-width: 200px;
    row-gap: 8px;
">
    <label for="type">Desired database type: </label>
    <select name="type">
        <option value="mysql">MySQL</option>
        <option value="csv">CSV</option>
    </select>
    <input type="submit" name="submitType" value="Next" />
</form>
</body>
</html>
