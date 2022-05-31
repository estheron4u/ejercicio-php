<?php

class DatabaseLoginLoader {
    private $xml;
    private $server;
    private $username;
    private $password;
    private $database;

    public function __construct(){
        $this->xml = $this->checkDatabaseLogin();
        $this->server = $this->xml->server;
        $this->username = $this->xml->user;
        $this->password = $this->xml->password;
        $this->database = $this->xml->database;
    }

    private function checkDatabaseLogin(){
        try {
            $xml = simplexml_load_file("login.xml");
            if(!$xml){
                throw new Exception("Cannot create object");
            }
            if (!$xml->user){
                throw new Exception("User field doesn't exist");
            }
            if (!$xml->password){
                throw new Exception("Password field doesn't exist");
            }
            if (!preg_match("/^[a-zA-Z\d]\w{1,14}$/", $xml->user)){
                throw new Exception("User format is not correct");
            }
            if (!preg_match("/^[a-zA-Z\d]\w{1,14}$/", $xml->password)) {
                throw new Exception("Password format is not correct");
            }
        } catch (Exception $e) {
            echo 'Exception: ',  $e->getMessage(), "\n";
            return null;
        }
        return $xml;
    }

    /**
     * @return SimpleXMLElement
     */
    public function getServer(){
        return $this->server;
    }

    /**
     * @return SimpleXMLElement
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @return SimpleXMLElement
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @return SimpleXMLElement
     */
    public function getDatabase(){
        return $this->database;
    }

}
