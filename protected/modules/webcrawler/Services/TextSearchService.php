<?php
/**
 * Created by PhpStorm.
 * User: Dobro
 * Date: 17.06.2016
 * Time: 4:16
 */

namespace webcrawler\Services;


class TextSearchService extends SearchService
{
    /**
     * @var String text
     */
    private $queryText;

    protected function getExp()
    {
        return "/(" . $this->queryText . ")/i";
    }

    protected function getType()
    {
        return SearchService::TYPE_TEXT;
    }

    /**
     * Set query substring
     * @param $text
     * @throws \CException
     */
    public function setQueryText($text)
    {
        if (!preg_match('/[\s\wА-Яа-я0-9,_-]+/', $text)) {
            throw new \CException('Неккоректная искомая строка');
        }
        $this->queryText = trim($text);
    }
}
