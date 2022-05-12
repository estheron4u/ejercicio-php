<?php

include('config.php');

class GetLoginData {
    protected $xml;

    public function __construct(){
        $this->xml = simplexml_load_file("login.xml") or die("Error: Cannot create object");
    }

    public function checkLoginData(){
        if (!$this->xml->user){
            die("Error: User field doesn't exist");
        }
        if (!$this->xml->password){
            die("Error: Password field doesn't exist");
        }
        if (!preg_match("/[a-zA-Z\d_.-]+/", $this->xml->user)){
            die("Error: User is not correct");
        }
        if (!preg_match("/[a-zA-Z_.-]+/", $this->xml->password)) {
            die("Error: Password is not correct");
        }
        return $this->xml;
    }
};

class DatabaseConnection { //TODO Why not use file for each class

    private $logindata;

    private $servername;
    private $username;
    private $password;
    private $database;

    public function __construct($servername, $database) {
        $this->logindata = new GetLoginData;

        $this->servername = $servername;
        $this->username = $this->logindata->checkLoginData()->user;
        $this->password = $this->logindata->checkLoginData()->password;
        $this->database = $database;
    }

    protected function connectToDatabase() {
        $connection = new mysqli($this->servername, $this->username, $this->password, $this->database);

        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error); //TODO die could be dangerous, exceptions are safer
        }
        return $connection;
    }
    public function getCustomers() {
        $sql = "SELECT customerName FROM customers";
        $result = $this->connectToDatabase()->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "Customer: {$row["customerName"]}\n";
            }
        } else {
            echo "0 results";
        }
    }
}


$customers = new DatabaseConnection($host, $database);
echo $customers->getCustomers();

