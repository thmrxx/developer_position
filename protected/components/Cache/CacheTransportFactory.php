<?php
namespace components\Cache;

class CacheTransportFactory
{
    /**
     * @param $storageType
     * @return CacheTransportInterface
     * @throws MCacheException
     */
    public static function getCacheTransport($storageType)
    {
        switch ($storageType) {
            case CacheClient::STORAGE_DB:
                return new CacheDbTransport();
                break;
            case CacheClient::STORAGE_FILE:
                return new CacheFileTransport();
                break;
            default:
                throw new MCacheException('Undefined storage type');
                break;
        }
    }
}