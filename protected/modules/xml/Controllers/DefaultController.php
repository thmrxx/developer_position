<?php
/**
 * @author Ilia Titov <i.titov@dengionline.com>
 * @date   : 14/06/16
 */

namespace Xml\Controllers;


use modules\xml\Services\CurrencyService;

class DefaultController extends \CController
{

    public function actionIndex()
    {
        $curName = \Yii::app()->request->getQuery('currency', 'rub');
        $currencyService = new CurrencyService();
        $curRate = $currencyService->getRate($curName);

        $this->render('/default/index', [
            'curRate' => $curRate,
        ]);
    }
}