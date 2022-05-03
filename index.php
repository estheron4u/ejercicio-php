<?php

// Get login data
$xml=simplexml_load_file("login.xml");

//Check login data

if (!preg_match("/[a-zA-Z\d_.-]+/", $xml->user) or !preg_match("/[a-zA-Z_.-]+/", $xml->password)){
    die("Error: Cannot create object");
};

class DatabaseConnection {

    // Declare variables
    private $servername;
    private $username;
    private $password;
    private $database;

    function __construct($servername, $username, $password, $database) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    // Create connection
    protected function connect() {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}

class CustomerNames extends DatabaseConnection {

    // Select data
    public function getCustomers() {
        $sql = "SELECT customerName FROM customers";
        $result = $this->connect()->query($sql);

        // Print data
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "Customer: " . $row["customerName"] . "\n";
            }
        } else {
            echo "0 results";
        }
    }
}

$customers = new CustomerNames("localhost", $xml->user, $xml->password, "classicmodels");
echo $customers->getCustomers();