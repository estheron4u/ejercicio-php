<?php

namespace DatabaseLoginLoader;

include_once 'DatabaseLoginLoaderInterface.php';

class DatabaseLoginLoaderJson implements DatabaseLoginLoaderInterface
{
    /**
     * @throws Exception
     */
    public function getLoginData()
    {
        $json = file_get_contents('../login.json');
        if (!$json) {
            throw new Exception("Cannot load login data file");
        }
        return json_decode($json);
    }
}