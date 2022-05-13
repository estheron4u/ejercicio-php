<?php
class GetDatabaseData {

    private $logindata;
    private $servername;
    private $database;

    public function __construct($servername, $database) {
        $this->logindata = new GetLoginData;
        $this->servername = $servername;
        $this->database = $database;
    }

    protected function connectToDatabase() {
        try {
            $connection = new mysqli($this->servername, $this->logindata->username, $this->logindata->password, $this->database);
        } catch (Exception $e) {
            echo 'Exception: ',  $e->getMessage(), "\n";
        }

        if ($connection->connect_error) {
            throw new Exception("Connection failed: " . $connection->connect_error);
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
};