<?php
namespace components\Cache\Models;

/**
 * This is the model class for table "cache".
 *
 * The followings are the available columns in table 'cache':
 * @property integer $c_id
 * @property integer $c_key
 * @property integer $c_datetime
 * @property integer $c_expire
 * @property string $c_value
 */
class CacheModel extends \CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cache';
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'c_id' => 'Cache ID',
            'c_key' => 'Cache key',
            'c_datetime' => 'Cache datetime',
            'c_expire' => 'Cache expire',
            'c_value' => 'Cache value',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Cache the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
