<?php
/**
 * @author Ilia Titov <i.titov@dengionline.com>
 * @date   : 14/06/16
 */

return [
    'name' => 'Pre-interview task for PHP-developer',
    'basePath' => __DIR__ . DIRECTORY_SEPARATOR . '..',
    'defaultController' => 'webCrawler/webCrawler',
    'components' => [
        'db' => [
            'connectionString' => 'mysql:host=localhost;dbname=test_db;', // Your configuration here
            'username' => '',
            'password' => '',
            'class' => CDbConnection::class,
        ]
    ],
    'aliases' => [
        'app' => dirname(__DIR__),
        'modules' => __DIR__ . '/../modules/',
        'vendor' => __DIR__ . '/../../vendor/',
        'Xml' => __DIR__ . '/../modules/xml/',
        'WebCrawler' => __DIR__ . '/../modules/webcrawler/',
    ],
    'import' => [
        'app.components.Cache.*'
    ],
    'modules' => [
        'xml' => [
            'class' => \Xml\XmlModule::class
        ],
        'webcrawler' => [
            'class' => \WebCrawler\WebCrawlerModule::class
        ]
    ]
];