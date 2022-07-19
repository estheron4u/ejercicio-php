<?php

class DatabaseLoginLoader {
    const LOGIN_DATA = "login.xml";
    private $xml;
    private $server;
    private $username;
    private $password;
    private $database;

    public function __construct(){
        $this->xml = simplexml_load_file(self::LOGIN_DATA);
        $this->server = $this->xml->server;
        $this->username = $this->xml->user;
        $this->password = $this->xml->password;
        $this->database = $this->xml->database;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getServer() : string {
        if(!$this->xml){
            throw new Exception("Cannot load login data file");
        }
        return $this->server->__toString();
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getUsername() : string{
        if(!$this->xml){
            throw new Exception("Cannot load login data file");
        }
        if (!$this->xml->user){
            throw new Exception("User field doesn't exist in login data file");
        }
        if (!preg_match("/^[a-zA-Z\d]\w{1,14}$/", $this->xml->user)){
            throw new Exception("User format is not correct in login data file");
        }
        return $this->username->__toString();
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getPassword() : string{
        if (!$this->xml->password){
            throw new Exception("Password field doesn't exist in login data file");
        }
        if (!preg_match("/^[a-zA-Z\d]\w{1,14}$/", $this->xml->password)) {
            throw new Exception("Password format is not correct in login data file");
        }
        return $this->password->__toString();
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getDatabase() : string{
        if(!$this->xml){
            throw new Exception("Cannot load login data file");
        }
        return $this->database->__toString();
    }

}
