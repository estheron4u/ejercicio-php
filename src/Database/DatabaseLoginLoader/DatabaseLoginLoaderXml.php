<?php

namespace DatabaseLoginLoader;

include_once 'DatabaseLoginLoaderInterface.php';

class DatabaseLoginLoaderXml implements DatabaseLoginLoaderInterface
{
    /**
     * @throws Exception
     */
    public function getLoginData()
    {
        $xml = simplexml_load_file('../login.xml');
        if (!$xml) {
            throw new Exception("Cannot load login data file");
        }
        return $xml;
    }

}
