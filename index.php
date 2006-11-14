<?php
error_reporting(E_ALL|E_STRICT);
date_default_timezone_set('Europe/London');

set_include_path('.' . PATH_SEPARATOR . './library/'
	 . PATH_SEPARATOR . './application/models'
	 . get_include_path());
include "Zend.php";

Zend::loadClass('Zend_Controller_Front');
Zend::loadClass('Zend_Controller_RewriteRouter');
Zend::loadClass('Zend_View');
Zend::loadClass('Zend_Config_Ini');
Zend::loadClass('Zend_Db');
Zend::loadClass('Zend_Db_Table');
Zend::loadClass('Zend_Filter_Input');

// register the input filters
Zend::register('post', new Zend_Filter_Input($_POST));
Zend::register('get', new Zend_Filter_Input($_GET));

// load configuration
$config = new Zend_Config_Ini('./application/config.ini', 'general');
Zend::register('config', $config);

// setup database
$db = Zend_Db::factory($config->db->adapter, $config->db->config->asArray());
Zend_Db_Table::setDefaultAdapter($db);

// register the view we are going to use
$view = new Zend_View();
$view->setScriptPath('./application/views');
Zend::register('view', $view);

// setup controller
$router = new Zend_Controller_RewriteRouter();
$baseUrl = substr($_SERVER['PHP_SELF'], 0, 
        strpos($_SERVER['PHP_SELF'], '/index.php'));
$router->setRewriteBase($baseUrl);
$controller = Zend_Controller_Front::getInstance();
$controller->setRouter($router);
$controller->setControllerDirectory('./application/controllers');
// run!
$controller->dispatch(); 
