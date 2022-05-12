<?php

include('config.php');

// Get login data
$xml=simplexml_load_file("login.xml"); //TODO why is this outside of class
//TODO also you removed a validation

//Check login data //TODO this comment could be a function name

if (!preg_match("/[a-zA-Z\d_.-]+/", $xml->user) or !preg_match("/[a-zA-Z_.-]+/", $xml->password)){ //TODO are you checking it exists, or the format
    die("Error: Cannot create object"); //TODO what object?
};

class DatabaseConnection { //TODO Why not use file for each class

    // Declare variables //TODO not really relevant
    private $servername;
    private $username;
    private $password;
    private $database;

    function __construct($servername, $username, $password, $database) { //TODO access modifier missing
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    // Create connection
    protected function connect() {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->database); //TODO no need to abbreviate 'connection' to 'conn'

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error); //TODO die could be dangerous, exceptions are safer
        }
        return $conn;
    }
}

class CustomerNames extends DatabaseConnection { //TODO why extend?

    // Select data
    public function getCustomers() {
        $sql = "SELECT customerName FROM customers";
        $result = $this->connect()->query($sql);

        // Print data
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "Customer: {$row["customerName"]}\n";
            }
        } else {
            echo "0 results";
        }
    }
}

$customers = new CustomerNames($host, $xml->user, $xml->password, $database);
echo $customers->getCustomers();

//TODO one git commit for 2 changes make sit it difficult to analyse history
