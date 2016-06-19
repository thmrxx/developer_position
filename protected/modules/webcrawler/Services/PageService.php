<?php
/**
 * Created by PhpStorm.
 * User: Dobro
 * Date: 17.06.2016
 * Time: 1:53
 */

namespace webcrawler\Services;

class PageService
{
    private $url;
    private $page;

    /**
     * @param $url - URL for get page
     * @throws \CException
     */
    public function __construct($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $this->url = $url;
        } else {
            throw new \CException('Некорректный URL');
        }

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $url, []);
        if ($res->getStatusCode() == 200) {
            $this->page = $res;
        } else {
            throw new \CException('Не удалось получить страницу');
        }
    }

    /**
     * Return page HTML
     * @return string html
     */
    public function getHtml()
    {
        return $this->page->getBody()->getContents();
    }

    /**
     * @return Page URL
     */
    public function getUrl()
    {
        return $this->url;
    }
}