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
     * @return SimpleXMLElement //TODO why not declare it at PHP level? And why not a string? - Declararlo a nivel de php es poner :string o :boolean o lo que sea a nivel de declarar la funcion. También hay que castearlo a string, es un tipo más correcto que un simplexmlelement
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
