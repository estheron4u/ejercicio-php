<?php

class GetLoginData {
    protected $xml;
    public $username;
    public $password;

    public function __construct(){
        try {
            $this->xml = simplexml_load_file("login.xml");
            $this->username = $this->checkLoginData()->user;
            $this->password = $this->checkLoginData()->password;
        } catch (Exception $e) {
            echo 'Exception: ',  $e->getMessage(), "\n";
        }

        if(!$this->xml){
            throw new Exception("Cannot create object");
        }
    }

    private function checkLoginData(){
        if (!$this->xml->user){
            throw new Exception("User field doesn't exist");
        }
        if (!$this->xml->password){
            throw new Exception("Password field doesn't exist");
        }
        if (!preg_match("/^[a-zA-Z0-9]\w{1,14}$/", $this->xml->user)){
            throw new Exception("User is not correct");
        }
        if (!preg_match("/^[a-zA-Z0-9]\w{1,14}$/", $this->xml->password)) {
            throw new Exception("Password is not correct");
        }
        return $this->xml;
    }
};