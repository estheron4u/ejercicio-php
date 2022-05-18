<?php

class GetLoginData {
    private $xml;
    public $username; //TODO using public class properties is considered a bad practice, getter/setter pattern is the way to go in this cases
    public $password;

    public function __construct(){
        try {
            $this->xml = simplexml_load_file("login.xml");
            /** TODO you validate twice, and the line can be translated as
             *  $this->checkLoginData()
             * $this->username = $this->user; // which is useless
             * Returning itself makes a function 'fluid', which has his own pros & cons
             */
            $this->username = $this->checkLoginData()->user;
            $this->password = $this->checkLoginData()->password;
        } catch (Exception $e) {
            echo 'Exception: ',  $e->getMessage(), "\n"; //TODO it doesn't stop!
        }

        if(!$this->xml){
            throw new Exception("Cannot create object");//TODO el construct no es un buen sitio para lanzar expcepciones
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
            throw new Exception("Password is not correct"); //TODO this would make me think that I put the wrong password, but not the wrong value
        }
        return $this->xml;
    }
};
