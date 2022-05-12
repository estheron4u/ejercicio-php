<?php

include('config.php');

class GetLoginData {
    protected $xml;
    public $username;
    public $password;

    public function __construct(){
        $this->xml = simplexml_load_file("login.xml") or die("Error: Cannot create object");
        try {
            $this->username = $this->checkLoginData()->user;
            $this->password = $this->checkLoginData()->password;
        } catch (Exception $e) {
            echo 'Exception: ',  $e->getMessage(), "\n";
        }
    }

    private function checkLoginData(){
        if (!$this->xml->user){
            throw new Exception("User field doesn't exist");
        }
        if (!$this->xml->password){
            throw new Exception("Password field doesn't exist");
        }
        if (!preg_match("/[a-zA-Z\d_.-]+/", $this->xml->user)){
            throw new Exception("User is not correct");
        }
        if (!preg_match("/[a-zA-Z_.-]+/", $this->xml->password)) {
            throw new Exception("Password is not correct");
        }
        return $this->xml;
    }
};

class DatabaseConnection { //TODO Why not use file for each class

    private $logindata;

    private $servername;
    private $database;

    public function __construct($servername, $database) {
        $this->logindata = new GetLoginData;

        $this->servername = $servername;
        $this->database = $database;
    }

    protected function connectToDatabase() {
        $connection = new mysqli($this->servername, $this->logindata->username, $this->logindata->password, $this->database);

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

