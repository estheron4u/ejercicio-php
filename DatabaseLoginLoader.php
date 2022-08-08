<?php

class DatabaseLoginLoader
{
    const LOGIN_DATA = "login.xml";
    private $server;
    private $user;
    private $password;
    private $database;

    /**
     * @throws Exception
     */
    private function getLoginData(): SimpleXMLElement
    {
        $xml = simplexml_load_file(self::LOGIN_DATA);
        if (!$xml) {
            throw new Exception("Cannot load login data file");
        }
        return $xml;
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
