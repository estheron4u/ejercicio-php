<?php

// Get login data
$xml=simplexml_load_file("login.xml") or die("Error: Cannot create object");

// Declare variables
$serverName = "localhost";
$userName = $xml->user;
//upsss, this commit will probably mess your merge
$passWord = $xml->password;
$dataBase = "classicmodels";

// Create connection
$conn = new mysqli($serverName, $userName, $passWord, $dataBase);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select data
$sql = "SELECT customerName FROM customers";
$queryResult = $conn->query($sql);

// Print data
if ($queryResult->num_rows > 0) {
    //oh no, he did it again
    while($row = $queryResult->fetch_assoc()) {
        echo "Customer: " . $row["customerName"] . "\n";
    }
} else {
    echo "0 results";
}
