<?php
namespace WebCrawler\Models;

use webcrawler\Services\SearchService;

/**
 * This is the model class for table "search_result".
 *
 * The followings are the available columns in table 'search_result':
 * @property integer $sr_id
 * @property string $sr_url
 * @property string $sr_type
 * @property string $sr_data
 * @property integer $sr_count
 */
class SearchResult extends \CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'search_result';
    }

    public function getId()
    {
        return $this->sr_id;
    }

    public function getUrl()
    {
        return $this->sr_url;
    }

    public function getType()
    {
        switch ($this->sr_type) {
            case SearchService::TYPE_LINKS:
                return 'Ссылки';
                break;
            case SearchService::TYPE_IMAGES:
                return 'Изображения';
                break;
            case SearchService::TYPE_TEXT:
                return 'Текст';
                break;
            default:
                return $this->sr_type;
        }
    }

    public function getResult()
    {
        return \CJavaScript::jsonDecode($this->sr_data, true);
    }

    public function getCount()
    {
        return $this->sr_count;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'sr_id' => 'ID request',
            'sr_url' => 'Request URL',
            'sr_type' => 'Type search',
            'sr_data' => 'Result data',
            'sr_count' => 'Count of results',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SearchResult the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
