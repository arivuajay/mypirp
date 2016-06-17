<?php

ini_set('display_errors', true);
error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING & ~E_NOTICE);
// change the following paths if necessary
$yii = dirname(__FILE__) . '/framework/yii.php';
$config = dirname(__FILE__) . '/protected/config/main.php';
include_once(dirname(__FILE__) . '/protected/config/constants.php');

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once($yii);

$suadmin_array = array('local.mypirpsuadmin');

if (in_array($_SERVER['HTTP_HOST'], $suadmin_array)) {

    $modules = array('suadmin');
    $def_mod = 'suadmin';
    define('SITENAME', 'MyPirpClass Super Admin');
} else {
    $modules = array('webpanel', 'affiliate');
    $def_mod = 'webpanel';
    define('SITENAME', 'MyPirpClass');
}

if ($modules) {
    defined('ENABLE_MODULES') ||
            @define('ENABLE_MODULES', implode(',', $modules));
    defined('DEFAULT_MODULE') ||
            @define('DEFAULT_MODULE', $def_mod);
}

$app = Yii::createWebApplication($config);

defined('SITEURL') ||
        @define('SITEURL', Yii::app()->createAbsoluteUrl("/"));

defined('DS') ||
        @define('DS', DIRECTORY_SEPARATOR);

$app->run();
