<?php

use components\Cache\CacheClient;

class CacheController extends \CController
{
    public function actionIndex()
    {
        $cache = new CacheClient('file');

        //$cache->flush();

        $cache->set(1,'set value');

        //$cache->add(2,'add value', time()+1000);
        //$cache->replace(1,'replace');
        //$cache->delete(2,'delete');
        //$cache->delete([1,2,3]);
        //$cache->get(1);
        //$cache->get([1,2,3]);

        $this->render('/cache/index', []);
    }

    public function getStack($cache)
    {
        echo '<pre>';
        var_dump($cache->getStack());
        echo '</pre>';
    }

}