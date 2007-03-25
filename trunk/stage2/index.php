<?php
error_reporting(E_ALL|E_STRICT);
date_default_timezone_set('Europe/London');

set_include_path('.' . PATH_SEPARATOR . './library/'
	 . PATH_SEPARATOR . './application/models/'
	 . PATH_SEPARATOR . './application/lib/'
	 . PATH_SEPARATOR . get_include_path());
include "Zend/Loader.php";

Zend_Loader::loadClass('Zend_Controller_Front');
Zend_Loader::loadClass('Zend_Registry');
Zend_Loader::loadClass('Zend_View');
Zend_Loader::loadClass('Zend_Config_Ini');
Zend_Loader::loadClass('Zend_Db');
Zend_Loader::loadClass('Zend_Db_Table');
Zend_Loader::loadClass('Zend_Debug');

// load configuration
$config = new Zend_Config_Ini('./application/config.ini', 'general');
Zend_Registry::set('config', $config);

// setup database
$dbAdapter = Zend_Db::factory($config->db->adapter, 
        $config->db->config->asArray());
Zend_Db_Table::setDefaultAdapter($dbAdapter);
Zend_Registry::set('dbAdapter', $dbAdapter);

// setup for authentication
Zend_Loader::loadClass('Controller_Plugin_Auth');
Zend_Loader::loadClass('Zend_Auth');

// setup controller
$frontController = Zend_Controller_Front::getInstance();
$frontController->throwExceptions(true);
$frontController->setControllerDirectory('./application/controllers');
$frontController->registerPlugin(new Controller_Plugin_Auth());

// run!
$frontController->dispatch();
