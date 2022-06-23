<?php
include_once('DatabaseConnector.php');

class DatabaseDataPrinter{
    private $sql;
    private $column;

    public function __construct($column, $table){
        $this->column = $column;
        $this->sql= "SELECT $column FROM $table"; //TODO better as a const
    }

   private function askQuery(){
        try {
            $result = DatabaseConnector::connectToDatabase()->query($this->sql); //TODO class is a printer, right? A printer does not understand SQL, not should know how to "query"
            if (!$result){
                throw new Exception(); //TODO Ok, but what happened?
            }
        } catch (Exception $e) {
            echo 'Exception: ',  $e->getMessage(), "\n";
            die(); //TODO I would avoid die from now on. Let the Exception rise through the code and manage it at the highest level
        }

        return $result;
    }

    public function printDatabaseData(){
        $result = $this->askQuery();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "$this->column: {$row[$this->column]}\n";
            }
        } else { //TODO good quick return candidate
            echo "0 results";
        }
    }

}
