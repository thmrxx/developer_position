<?php
namespace components\Cache;

/**
 * Class Cache
 *  set
 *      Most common command. Store this data, possibly overwriting any existing data.
 *      New items are at the top of the LRU.
 *  add
 *      Store this data, only if it does not already exist. New items are at the top
 *      of the LRU. If an item already exists and an add fails, it promotes the item
 *      to the front of the LRU anyway.
 * replace
 *      Store this data, but only if the data already exists. Almost never used, and
 *      exists for protocol completeness (set, add, replace, etc)
 * append
 *      Add this data after the last byte in an existing item. This does not allow you
 *      to extend past the item limit. Useful for managing lists.
 *      prepend
 *      Same as append, but adding new data before existing data.
 *  cas
 *      Check And Set (or Compare And Swap). An operation that stores data, but only
 *      if no one else has updated the data since you read it last. Useful for resolving
 *      race conditions on updating cache data.
 *  get
 *      Command for retrieving data. Takes one or more keys and returns all found items.
 *  gets
 *      An alternative get command for using with CAS. Returns a CAS identifier (a unique
 *      64bit number) with the item. Return this value with the cas command. If the item
 *      's CAS value has changed since you gets'ed it, it will not be stored.
 *  delete
 *      Removes an item from the cache, if it exists.
 *  incr/decr
 *      Increment and Decrement. If an item stored is the string representation of a 64bit
 *      integer, you may run incr or decr commands to modify that number. You may only incr
 *      by positive values, or decr by positive values. They does not accept negative values.
 *      If a value does not already exist, incr/decr will fail.
 */

class CacheClient
{
    /**
     * Storage type is database
     */
    const STORAGE_DB = 'db';
    /**
     * Storage type is file
     */
    const STORAGE_FILE = 'file';

    /**
     * @var CachePool object
     */
    private $pool;

    /**
     * @param $storageType CacheClient::STORAGE_DB|CacheClient::STORAGE_FILE
     * @throws MCacheException
     */
    public function __construct($storageType)
    {
        $this->pool = new CachePool(CacheTransportFactory::getCacheTransport($storageType));
    }

    /**
     * Store this data, possibly overwriting any existing data.
     * @param $key
     * @param $value
     * @param int $expire
     */
    public function set($key, $value, $expire = 0)
    {
        $item = new CacheItem($key);
        $item->set($value);
        $item->expiresAfter($expire);
        $this->pool->saveDeferred($item);
    }

    /**
     * Store this data, only if it does not already exist.
     * @param $key
     * @param $value
     * @param int $expire
     */
    public function add($key, $value, $expire = 0)
    {
        if (!$this->pool->hasItem($key)) {
            $this->set($key, $value, $expire);
        }
    }

    /**
     * Store this data, but only if the data already exists.
     * @param $key
     * @param $value
     * @param int $expire
     */
    public function replace($key, $value, $expire = 0)
    {
        if ($this->pool->hasItem($key)) {
            $this->set($key, $value, $expire);
        }
    }

    /**
     * Command for retrieving data. Takes one or more keys and returns all found items.
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        if (is_array($key)) {
            return array_map(function ($item) {
                return $item->get();
            }, $this->pool->getItems($key));
        } else {
            return $this->pool->getItem($key)->get();
        }
    }

    /**
     * Removes an item from the cache, if it exists.
     * @param $key
     * @return bool
     */
    public function delete($key)
    {
        if (is_array($key)) {
            return $this->pool->deleteItems($key);
        } else {
            return $this->pool->deleteItem($key);
        }
    }

    /**
     * Removes all items from the cache
     */
    public function flush()
    {
        return $this->pool->clear();
    }

    /**
     * Persists any deferred cache items.
     */
    public function commit()
    {
        $this->pool->commit();
    }
}