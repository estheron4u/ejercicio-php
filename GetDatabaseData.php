<?php
class GetDatabaseData {

    private $logindata;
    private $servername;
    private $database;

    public function __construct($servername, $database) {
        $this->logindata = new GetLoginData; //TODO too slow, __construct is not the bets place for this
        $this->servername = $servername;
        $this->database = $database;
    }

    private function connectToDatabase() {
        try {
            $connection = new mysqli($this->servername, $this->logindata->username, $this->logindata->password, $this->database);
        } catch (Exception $e) {
            echo 'Exception: ',  $e->getMessage(), "\n"; //TODO it doesn't stop!
        }

        if ($connection->connect_error) {
            throw new Exception("Connection failed: " . $connection->connect_error); //TODO missing throws tag
        }
        return $connection;
    }
    public function getCustomers() {
        $sql = "SELECT customerName FROM customers"; //TODO this value doesn't change during execution, so it makes sense to declare it as a CONST
        $result = $this->connectToDatabase()->query($sql); //TODO if you are not handling the exception, you should declare the function may throw one

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "Customer: {$row["customerName"]}\n";
            }
        } else {
            echo "0 results";
        }
    }
};
