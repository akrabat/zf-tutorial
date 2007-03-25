<?php

class Controller_Plugin_Auth extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $registry = Zend_Registry::getInstance();
        $authSession = $registry->get('authSession');
        
        if (!isset($authSession->user) && !isset($_POST['username']))
        {
            $request->setControllerName('auth');
            $request->setActionName('login');
        }
    }
}