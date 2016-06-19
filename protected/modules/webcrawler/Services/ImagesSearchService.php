<?php
/**
 * Created by PhpStorm.
 * User: Dobro
 * Date: 17.06.2016
 * Time: 4:16
 */

namespace webcrawler\Services;


class ImagesSearchService extends SearchService
{
    protected function getExp()
    {
        return "/<img[\s]+[^>]*src=['\"\s]*([^\"'>\s]+)['\"\s]*[^>]*>/i";
    }

    protected function getType()
    {
        return SearchService::TYPE_IMAGES;
    }
}
