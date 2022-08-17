<?php

include_once('DatabaseLoginLoaderXml.php');
include_once('DatabaseLoginLoaderJson.php');

class DatabaseLoginLoaderFactory
{
    public const XML = 'xml';
    public const JSON = 'json';

    /**
     * @throws Exception
     */
    public function getLoginLoaderService(string $serviceType): DatabaseLoginLoaderInterface
    {
        if ($serviceType === self::JSON) {
            return new DatabaseLoginLoaderJson();
        }
        if ($serviceType === self::XML) {
            return new DatabaseLoginLoaderXml();
        }
        throw new Exception('Service non-existent');
    }
}
