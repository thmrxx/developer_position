<?php
/**
 * Created by PhpStorm.
 * User: Dobro
 * Date: 17.06.2016
 * Time: 9:19
 */

namespace webcrawler\Services;


class SearchServiceFactory
{
    public static function getService($type, $params)
    {
        switch ($type) {
            case SearchService::TYPE_LINKS:
                return new LinksSearchService();
                break;
            case SearchService::TYPE_IMAGES:
                return new ImagesSearchService();
                break;
            case SearchService::TYPE_TEXT:
                $textSearchService = new TextSearchService();
                $textSearchService->setQueryText($params['text']);
                return $textSearchService;
                break;
            default:
                throw new \CException('Параметры поиска не верны');
                break;
        }
    }
}