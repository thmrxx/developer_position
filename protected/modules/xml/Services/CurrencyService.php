<?php
/**
 * Created by PhpStorm.
 * User: Dobro
 * Date: 21.06.2016
 * Time: 7:12
 */

namespace modules\xml\Services;


use GuzzleHttp\Client;

class CurrencyService
{
    const URL = 'https://www.onlinedengi.ru/dev/xmltalk.php';
    const STATUS_OK = 'ok';
    const STATUS_ERROR = 'error';

    private function action($action)
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><request></request>');
        $xml->addChild('action', $action);
        $xml = $xml->asXML();

        $client = new Client();

        $res = $client->request('POST', self::URL, [
            'form_params' => ['xml' => $xml],
            'timeout' => 5,
        ]);

        if ($res->getStatusCode() == 200) {
            $data = simplexml_load_string($res->getBody());
            if ($data->status == self::STATUS_ERROR) {
                throw new \CException('Service error: ' . $data->comment);
            }

            return $data;
        } else {
            throw new \CException('Error get data');
        }
    }

    public function getCurrencyRates()
    {
        return $this->toArray($this->action('get_currency_rates'));
    }

    public function getRate($cur = 'rub')
    {
        $rates = $this->getCurrencyRates();
        foreach ($rates['currency'] as $rate) {
            if (mb_strtolower($rate['name']) == mb_strtolower($cur)) {
                return $rate;
            }
        }
        throw new \CException('Currency not found');
    }

    private function toArray($obj)
    {
        return json_decode(json_encode($obj), TRUE);
    }
}
