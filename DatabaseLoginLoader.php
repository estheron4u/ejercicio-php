<?php

class DatabaseLoginLoader {
    private $xml;
    private $server;
    private $username;
    private $password;
    private $database;

    public function __construct(){
        $this->xml = $this->checkDatabaseLogin(); //TODO probably too slow for a construct
        $this->server = $this->xml->server;
        $this->username = $this->xml->user;
        $this->password = $this->xml->password;
        $this->database = $this->xml->database;
    }

    private function checkDatabaseLogin(){
        try {
            $xml = simplexml_load_file("login.xml");//TODO const candidate
            if(!$xml){
                throw new Exception("Cannot create object");//TODO what???
            }
            if (!$xml->user){
                throw new Exception("User field doesn't exist"); //TODO where?
            }
            if (!$xml->password){
                throw new Exception("Password field doesn't exist"); //TODO where?
            }
            if (!preg_match("/^[a-zA-Z\d]\w{1,14}$/", $xml->user)){
                throw new Exception("User format is not correct"); //TODO where?
            }
            if (!preg_match("/^[a-zA-Z\d]\w{1,14}$/", $xml->password)) {
                throw new Exception("Password format is not correct"); //TODO where?
            }
        } catch (Exception $e) {
            echo 'Exception: ',  $e->getMessage(), "\n";
            return null;
        }
        return $xml;
    }

    /**
     * @return SimpleXMLElement //TODO why not declare it at PHP level? And why not a string?
     */
    public function getServer(){
        return $this->server;
    }

    /**
     * @return SimpleXMLElement //TODO why not declare it at PHP level? And why not a string?
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @return SimpleXMLElement //TODO why not declare it at PHP level? And why not a string?
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @return SimpleXMLElement //TODO why not declare it at PHP level? And why not a string?
     */
    public function getDatabase(){
        return $this->database;
    }

}
