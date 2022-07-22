<?php

class DatabaseLoginLoader
{
    const LOGIN_DATA = "login.xml";

    /**
     * @throws Exception
     */
    private function getLoginData()
    {
        $xml = simplexml_load_file(self::LOGIN_DATA);
        if (!$xml) {
            throw new Exception("Cannot load login data file");
        }
        return $xml;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getServer(): string
    {
        if (!$this->getLoginData()->server) {
            throw new Exception("Server field doesn't exist in login data file");
        }
        $server = $this->getLoginData()->server;
        return (string)$server;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getUsername(): string
    {
        if (!$this->getLoginData()->user) {
            throw new Exception("User field doesn't exist in login data file");
        }
        if (!preg_match("/^[a-zA-Z\d]\w{1,14}$/", $this->getLoginData()->user)) {
            throw new Exception("User format is not correct in login data file");
        }
        $username = $this->getLoginData()->user;
        return (string)$username;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getPassword(): string
    {
        if (!$this->getLoginData()->password) {
            throw new Exception("Password field doesn't exist in login data file");
        }
        if (!preg_match("/^[a-zA-Z\d]\w{1,14}$/", $this->getLoginData()->password)) {
            throw new Exception("Password format is not correct in login data file");
        }
        $password = $this->getLoginData()->password;
        return (string)$password;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getDatabase(): string
    {
        if (!$this->getLoginData()->database) {
            throw new Exception("Database field doesn't exist in login data file");
        }
        $database = $this->getLoginData()->database;
        return (string)$database;
    }

}
