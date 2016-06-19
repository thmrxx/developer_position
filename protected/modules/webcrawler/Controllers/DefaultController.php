<?php
/**
 * @author Ilia Titov <i.titov@dengionline.com>
 * @date   : 14/06/16
 */

namespace WebCrawler\Controllers;

use WebCrawler\Models\SearchResult;
use webcrawler\Services;

class DefaultController extends \CController
{
    public $layout = 'main';

    public function actionIndex()
    {
        $this->render('/default/index', []);
    }

    public function actionView()
    {
        $results = SearchResult::model()->findAll([
            'order' => 'sr_id DESC',
        ]);

        $this->render('/default/view', [
            'results' => $results,
        ]);
    }

    public function actionViewItem()
    {
        if (\Yii::app()->request->isAjaxRequest) {
            $id = intval(\Yii::app()->request->getPost('id'));
            $item = SearchResult::model()->findByPk($id);
            if (!$item) {
                echo \CHtml::tag('h2', ['class' => 'text-danger', 'Не найдено']);
            }

            switch ($item->sr_type) {
                case Services\SearchService::TYPE_LINKS:
                case Services\SearchService::TYPE_IMAGES:
                    $result = array_map(function ($i) {
                        return \CHtml::link($i, $i, ['class' => 'label label-primary']);
                    }, $item->result);
                    break;
                default:
                    $result = $item->result;
            }

            echo implode(', ', $result);

            \Yii::app()->end();
        } else throw new \CHttpException(403, 'Некорректный запрос');
    }

    public function actionSearch()
    {
        if (\Yii::app()->request->isAjaxRequest) {
            try {
                $url = \Yii::app()->request->getPost('form-url');
                $type = \Yii::app()->request->getPost('form-type');
                $text = \Yii::app()->request->getPost('form-text');

                $s = Services\SearchServiceFactory::getService($type, ['text' => $text]);

                $page = new Services\PageService($url);

                $result = $s->setPage($page)
                    ->search()
                    ->saveToDb()
                    ->getResult();

                echo \CJavaScript::jsonEncode(array(
                    'message' => ($result['count'] ? 'Результатов поиска: ' . $result['count'] . '. ' . \CHtml::link('Посмотреть', $this->createUrl('view')) : ''),
                    'result' => $result['result'],
                    'error' => false,
                ));

                \Yii::app()->end();

            } catch (\CException $e) {
                echo \CJavaScript::jsonEncode(array(
                    'error' => true,
                    'message' => $e->getMessage(),
                ));
            }
        } else throw new \CHttpException(403, 'Некорректный запрос');
    }
}