<?php
/**
 * @author Ilia Titov <i.titov@dengionline.com>
 * @date   : 14/06/16
 */

namespace WebCrawler\Controllers;


class DefaultController extends \CController
{

    public function actionIndex()
    {
        // Your implementation here
        
        $this->render('/default/index', []);
    }
}