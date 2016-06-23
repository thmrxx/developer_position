<?php
namespace components\Cache;

use components\Cache\Models\CacheModel;
use Psr\Cache\CacheItemInterface;

class CacheDbTransport implements CacheTransportInterface
{

    /**
     * Get data from storage item and create CacheItem object
     * @param $key - item key
     * @return CacheItemInterface
     */
    public function getItem($key)
    {
        $cacheItem = new CacheItem($key);
        $item = CacheModel::model()->findByAttributes(['c_key' => $key]);

        if ($item && $item->c_expire > 0 && ($item->c_expire) < time()) {
            $item->delete();
            unset($item);
        }

        if($item) {
            $cacheItem->set(unserialize($item->c_value), false);
            $cacheItem->setExists(true);
            if($item->c_expire > 0) {
                $cacheItem->expiresAfter($item->c_expire);
            }
        }

        return $cacheItem;
    }

    /**
     * Delete cache item in storage
     * @param $key
     * @return mixed
     */
    public function deleteItem($key)
    {
        $item = CacheModel::model()->findByAttributes(['c_key' => $key]);
        if($item) {
            return $item->delete();
        }
        return true;
    }

    /**
     * Clear storage
     * @return boolean
     */
    public function deleteAll()
    {
        return CacheModel::model()->deleteAll();
    }

    /**
     * Save item in storage
     * @param CacheItemInterface $item
     * @return boolean
     */
    public function saveItem(CacheItemInterface $item)
    {
        $record = CacheModel::model()->findByAttributes(['c_key' => $item->getKey()]);
        if(!$record) {
            $record = new CacheModel();
            $record->c_key = $item->getKey();
        }
        $record->c_datetime = time();
        $record->c_value = serialize($item->get());
        $record->c_expire = $item->getExpire();
        return $record->save();
    }
}