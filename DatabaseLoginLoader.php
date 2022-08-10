<?php

class DatabaseLoginLoader
{
    private $server;
    private $user;
    private $password;
    private $database;
    private $loginfile;

    public function __construct($loginfile)
    {
        $this->loginfile = $loginfile;
    }

    /**
     * Checks if login file is json or xml and returns its content
     * @return mixed|SimpleXMLElement
     * @throws Exception
     */
    private function getLoginData()
    {
        $decodedfile = file_get_contents($this->loginfile);
        if (json_decode($decodedfile) === null) {
            $xml = simplexml_load_file($this->loginfile);
            if (!$xml) {
                throw new Exception("Cannot load login data file");
            }
            return $xml;
        } else {
            return json_decode($decodedfile);
        }
    }

    /**
     * @throws Exception
     */
    public function loadLoginData()
    {
        $logindata = $this->getLoginData();
        if (!$logindata->server) {
            throw new Exception("Server field doesn't exist in login data file");
        }
        if (!$logindata->user) {
            throw new Exception("User field doesn't exist in login data file");
        }
        if (!preg_match("/^[a-zA-Z\d]\w{1,14}$/", $logindata->user)) {
            throw new Exception("User format is not correct in login data file");
        }
        if (!$logindata->password) {
            throw new Exception("Password field doesn't exist in login data file");
        }
        if (!preg_match("/^[a-zA-Z\d\s]{1,14}$/", $logindata->password)) {
            throw new Exception("Password format is not correct in login data file");
        }
        if (!$logindata->database) {
            throw new Exception("Database field doesn't exist in login data file");
        }
        $this->server = $logindata->server;
        $this->user = $logindata->user;
        $this->password = $logindata->password;
        $this->database = $logindata->database;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getServer(): string
    {
        if ($this->server === null) {
            $this->loadLoginData();
        }
        return (string)$this->server;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getUsername(): string
    {
        if ($this->user === null) {
            $this->loadLoginData();
        }
        return (string)$this->user;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getPassword(): string
    {
        if ($this->password === null) {
            $this->loadLoginData();
        }
        return (string)$this->password;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getDatabase(): string
    {
        if ($this->database === null) {
            $this->loadLoginData();
        }
        return (string)$this->database;
    }

}
