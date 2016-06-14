<?php

/**
 * @author Ilia Titov <i.titov@dengionline.com>
 * @date   : 14/06/16
 */
namespace WebCrawler;

use WebCrawler\Controllers\DefaultController;

/**
 * Class WebCrawlerModule
 * @package WebCrawler
 */
class WebCrawlerModule extends \CWebModule
{
    const CONTROLLER_WEB_CRAWLER = 'webCrawler';

    /**
     * {@inheritdoc}
     */
    public function __construct($id, $parent)
    {
        $this->controllerMap = [
            self::CONTROLLER_WEB_CRAWLER => DefaultController::class
        ];
        $this->defaultController = self::CONTROLLER_WEB_CRAWLER;
        parent::__construct($id, $parent);
    }


}