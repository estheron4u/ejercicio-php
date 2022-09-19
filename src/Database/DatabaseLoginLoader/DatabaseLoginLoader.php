<?php

namespace DatabaseLoginLoader;

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
    public function loadLoginData(): void
    {
        $loginLoader = new DatabaseLoginLoaderFactory();
        $loginService = $loginLoader->getLoginLoaderService($this->serviceType);
        $loginData = $loginService->getLoginData();
        $exceptionMessage = [];
        if (!$loginData->server) {
            $exceptionMessage[] = "Server field doesn't exist in login data file";
        }
        if (!$loginData->user) {
            $exceptionMessage[] = "User field doesn't exist in login data file";
        }
        if (!preg_match("/^[a-zA-Z\d]\w{1,14}$/", $loginData->user)) {
            $exceptionMessage[] = "User format is not correct in login data file";
        }
        if (!$loginData->password) {
            $exceptionMessage[] = "Password field doesn't exist in login data file";
        }
        if (!preg_match("/^[a-zA-Z\d\s]{1,14}$/", $loginData->password)) {
            $exceptionMessage[] = "Password format is not correct in login data file";
        }
        if (!$loginData->database) {
            $exceptionMessage[] = "Database field doesn't exist in login data file";
        }
        if (count($exceptionMessage) > 0) {
            $exceptionMessage = implode(",\n", $exceptionMessage);
            throw new Exception($exceptionMessage);
        }
        $this->server = $loginData->server;
        $this->user = $loginData->user;
        $this->password = $loginData->password;
        $this->database = $loginData->database;
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
