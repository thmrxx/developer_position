<?php
namespace components\Cache;

use components\Cache\Models\CacheModel;
use Psr\Cache\CacheItemInterface;

class CacheFileTransport implements CacheTransportInterface
{
    private $dir = __DIR__ . '/Files/';

    /**
     * Generate filename
     * @param $key
     * @return string
     */
    private function getFileName($key)
    {
        return $this->dir . sha1($key);
    }

    /**
     * Get data from storage item and create CacheItem object
     * @param $key - item key
     * @return CacheItemInterface
     */
    public function getItem($key)
    {
        $cacheItem = new CacheItem($key);

        $filename = $this->getFileName($key);
        if (file_exists($filename)) {
            $file = file($filename);
            $cacheItemFile = unserialize($file[0]);
            $cacheItemFile->setExists(true);
            if ($cacheItemFile->getExpire() > 0 && ($cacheItemFile->getExpire()) < time()) {
                unlink($filename);
                unset($cacheItemFile);
            }
        }

        return $cacheItemFile ? $cacheItemFile : $cacheItem;
    }

    /**
     * Delete cache item in storage
     * @param $key
     * @return mixed
     */
    public function deleteItem($key)
    {
        $filename = $this->getFileName($key);
        if (file_exists($filename)) {
            unlink($filename);
        }
        return true;
    }

    /**
     * Clear storage
     * @return boolean
     */
    public function deleteAll()
    {
        foreach (glob($this->dir . '*') as $f) {
            unlink($f);
        }
        return true;
    }

    /**
     * Save item in storage
     * @param CacheItemInterface $item
     * @return boolean
     */
    public function saveItem(CacheItemInterface $item)
    {
        $fp = fopen($this->getFileName($item->getKey()), 'w');
        $write = fwrite($fp, serialize($item));
        fclose($fp);
        return $write;
    }
}