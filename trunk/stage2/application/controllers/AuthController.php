<?php
Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable');

class AuthController extends Zend_Controller_Action 
{
    function init()
    {
        $this->initView();
        $this->view->baseUrl = $this->_request->getBaseUrl();
    }
        
    function indexAction()
    {
        $this->_redirect('/');
    }
    
    function loginAction()
    {
        $this->view->message = '';
        if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
        
            // collect from registry
            $dbAdapter = Zend_Registry::get('dbAdapter');
            $authSession = Zend_Registry::get('authSession');
            
            // setup Zend_Auth adapter for a database table
            $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
            $authAdapter->setTableName('users');
            $authAdapter->setIdentityColumn('username');
            $authAdapter->setCredentialColumn('password');
            
            
            // Set the input credential values (from login form)
            $filter = new Zend_Filter_StripTags();
            $username = $filter->filter($this->_request->getPost('username'));
            $password = $filter->filter($this->_request->getPost('password'));
            $authAdapter->setIdentity($username);
            $authAdapter->setCredential($password);
            
			// do the authentication 
            $result = $authAdapter->authenticate();
            $authSession->valid = $result->isValid();
            if ($result->isValid()) {
                // success : store database row to session
                $authSession->user = $authAdapter->getResultRowObject();
                $this->_redirect('/');
            }
            else
            {
                // failure: clear database row from session
                $authSession->user = null;
                $this->view->message = 'Login failed.';
            }
        }
        
        $this->view->title = "Log in";
        $this->render();
        
    }
    
    function logoutAction()
    {
        $authSession = Zend_Registry::get('authSession');
        $authSession->valid = false;
        $authSession->user = null;
        
        $this->_redirect('/');
    }
}