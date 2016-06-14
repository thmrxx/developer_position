<?php
/**
 * @author Ilia Titov <i.titov@dengionline.com>
 * @date   : 14/06/16
 */

namespace Xml;


use Xml\Controllers\DefaultController;

class XmlModule extends \CWebModule
{
    const CONTROLLER_DEFAULT = 'xml';

    /**
     * {@inheritdoc}
     */
    public function __construct($id, $parent)
    {
        $this->controllerMap = [
            self::CONTROLLER_DEFAULT => DefaultController::class
        ];
        $this->defaultController = self::CONTROLLER_DEFAULT;
        parent::__construct($id, $parent);
    }
}