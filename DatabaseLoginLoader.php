<?php

include_once 'DatabaseLoginLoaderFactory.php';

class DatabaseLoginLoader
{
    private $server;
    private $user;
    private $password;
    private $database;
    private $serviceType;

    public function __construct($serviceType)
    {
        $this->serviceType = $serviceType;
    }

    /**
     * @throws Exception
     */
    public function loadLoginData()
    {
        $loginloader = new DatabaseLoginLoaderFactory();
        $loginservice = $loginloader->getLoginLoaderService($this->serviceType);
        $logindata = $loginservice->getLoginData();
        $exceptionmessage = [];
        if (!$logindata->server) {
            $exceptionmessage[] = "Server field doesn't exist in login data file";
        }
        if (!$logindata->user) {
            $exceptionmessage[] = "User field doesn't exist in login data file";
        }
        if (!preg_match("/^[a-zA-Z\d]\w{1,14}$/", $logindata->user)) {
            $exceptionmessage[] = "User format is not correct in login data file";
        }
        if (!$logindata->password) {
            $exceptionmessage[] = "Password field doesn't exist in login data file";
        }
        if (!preg_match("/^[a-zA-Z\d\s]{1,14}$/", $logindata->password)) {
            $exceptionmessage[] = "Password format is not correct in login data file";
        }
        if (!$logindata->database) {
            $exceptionmessage[] = "Database field doesn't exist in login data file";
        }
        if(count($exceptionmessage) > 0){
            $exceptionmessage = implode(",\n", $exceptionmessage);
            throw new Exception($exceptionmessage);
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
