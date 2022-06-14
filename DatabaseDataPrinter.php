<?php
include_once('DatabaseConnector.php');

class DatabaseDataPrinter{
    private $sql;
    private $column;

    public function __construct($column, $table){
        $this->column = $column;
        $this->sql= "SELECT $column FROM $table";
    }

    private function askQuery(){
        try {
            $instance = DatabaseConnector::getInstance();
            $result = $instance->getConnection()->query($this->sql);
            if (!$result){
                throw new Exception();
            }
        } catch (Exception $e) {
            echo 'Exception: ',  $e->getMessage(), "\n";
            die();
        }

        return $result;
    }

    public function printDatabaseData(){
        $result = $this->askQuery();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "$this->column: {$row[$this->column]}\n";
            }
        } else {
            echo "0 results";
        }
    }

}