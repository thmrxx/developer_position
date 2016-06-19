<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Console Application',

    'components' => [
        'db' => require(dirname(__FILE__) . '/db.php'),
    ],
);