<?php

class DatabaseLoginLoader {
    private $xml;
    private $server;
    private $username;
    private $password;
    private $database;

    public function __construct(){
        $this->xml = $this->checkDatabaseLogin(); //TODO probably too slow for a construct - Esto es que se puede hacer el check en los getters en vez de en el construct
        $this->server = $this->xml->server;
        $this->username = $this->xml->user;
        $this->password = $this->xml->password;
        $this->database = $this->xml->database;
    }

    private function checkDatabaseLogin(){
        $xml = simplexml_load_file("login.xml");//TODO const candidate
        $msg = '';
        if(!$xml){
            $msg .= "Cannot load login data file\n";
        }
        if (!$xml->user){
            $msg .= "User field doesn't exist in login data file\n";
        }
        if (!$xml->password){
            $msg .= "Password field doesn't exist in login data file\n";
        }
        if (!preg_match("/^[a-zA-Z\d]\w{1,14}$/", $xml->user)){
            $msg .= "User format is not correct in login data file\n";
        }
        if (!preg_match("/^[a-zA-Z\d]\w{1,14}$/", $xml->password)) {
            $msg .= "Password format is not correct in login data file\n";
        }
        if (strlen($msg) > 0){
            throw new Exception($msg);
        }
        return $xml;
    }


    /**
     * @return string
     */
    public function getServer() : string {
        return $this->server->__toString();
    }

    /**
     * @return string
     */
    public function getUsername() : string{
        return $this->username->__toString();
    }

    /**
     * @return string
     */
    public function getPassword() : string{
        return $this->password->__toString();
    }

    /**
     * @return string
     */
    public function getDatabase() : string{
        return $this->database->__toString();
    }

}
