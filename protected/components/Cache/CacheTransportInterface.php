<?php

namespace components\Cache;

use Psr\Cache\CacheItemInterface;

interface CacheTransportInterface
{
    /**
     * Get data from storage item and create CacheItem object
     * @param $key - item key
     * @return CacheItemInterface
     */
    public function getItem($key);

    /**
     * Delete cache item in storage
     * @param $key
     * @return mixed
     */
    public function deleteItem($key);

    /**
     * Clear storage
     * @return boolean
     */
    public function deleteAll();

    /**
     * Save item in storage
     * @param CacheItemInterface $item
     * @return boolean
     */
    public function saveItem(CacheItemInterface $item);
}