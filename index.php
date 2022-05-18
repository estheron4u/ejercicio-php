<?php

// Get login data
$xml=simplexml_load_file("login.xml") or die("Error: Cannot create object");

// Declare variables
$servername = "localhost";
$username = $xml->user;
//upsss, this commit will probably mess your merge
$password = $xml->password;
$database = "classicmodels";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select data
$sql = "SELECT customerName FROM customers";
$result = $conn->query($sql);

// Print data
if ($result->num_rows > 0) {
    //oh no, he did it again
    while($row = $result->fetch_assoc()) {
        echo "Customer: " . $row["customerName"] . "\n";
    }
} else {
    echo "0 results";
}
