<?php
/**
 * Created by PhpStorm.
 * User: Dobro
 * Date: 17.06.2016
 * Time: 4:16
 */

namespace webcrawler\Services;

use webcrawler\Models;
use WebCrawler\Models\SearchResult;

abstract class SearchService
{
    const TYPE_LINKS = 'links';
    const TYPE_IMAGES = 'images';
    const TYPE_TEXT = 'text';

    /**
     * @var $page PageService
     */
    private $page;
    /**
     * @var Array results
     */
    private $result = [];

    /**
     * @var Count results
     */
    private $count = 0;

    public function __construct()
    {
    }

    abstract protected function getExp();

    abstract protected function getType();

    /**
     * Set page for search
     * @param PageService $page
     * @return $this
     */
    public function setPage(PageService $page)
    {
        $this->page = $page;
        return $this;
    }

    public function search()
    {
        if ($this->page) {
            preg_match_all($this->getExp(), $this->page->getHtml(), $matches);
            if (!count($matches[1])) {
                throw new \CException('Ничего не найдено');
            }

            $this->result = $this->prepareData($matches[1]);
            $this->count = count($matches[1]); // считаем количество найденных на странице эл-ов (независимо от обработки)
        }
        return $this;
    }

    /**
     * Prepare data before save or return
     * @param $data
     * @return mixed
     */
    protected function prepareData($data)
    {
        return array_values(array_unique($data));
    }

    /**
     * Save results to database
     * @return $this
     * @throws \CDbException
     */
    public function saveToDb()
    {
        if ($this->count) {
            $res = new SearchResult();
            $res->sr_url = $this->page->getUrl();
            $res->sr_type = $this->getType();
            $res->sr_data = \CJavaScript::jsonEncode($this->result);
            $res->sr_count = $this->count;
            if (!$res->save()) {
                throw new \CDbException('Не удалось сохранить результат поиска');
            }
        }
        return $this;
    }

    /**
     * @return array result
     */
    public function getResult()
    {
        return [
            'result' => $this->result,
            'count' => $this->count,
        ];
    }
}