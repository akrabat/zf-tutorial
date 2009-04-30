<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->title = "My Albums";
        $this->view->headTitle($this->view->title, 'PREPEND');
        $albums = new Model_DbTable_Albums();
        $this->view->albums = $albums->fetchAll();
    }

    public function addAction()
    {
        $this->view->title = "Add new album";
        $this->view->headTitle($this->view->title, 'PREPEND');

        $form = new Form_Album();
        $form->submit->setLabel('Add');
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                $artist = $form->getValue('artist');
                $title = $form->getValue('title');
                $albums = new Model_DbTable_Albums();
                $albums->addAlbum($artist, $title);
                
                $this->_redirect('/');
            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        $this->view->title = "Edit album";
        $this->view->headTitle($this->view->title, 'PREPEND');
        
        $form = new Form_Album();
        $form->submit->setLabel('Save');
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = (int)$form->getValue('id');
                $artist = $form->getValue('artist');
                $title = $form->getValue('title');
                $albums = new Model_DbTable_Albums();
                $albums->updateAlbum($id, $artist, $title);
                
                $this->_redirect('/');
            } else {
                $form->populate($formData);
            }
        } else {
            $id = $this->_request->getParam('id', 0);
            if ($id > 0) {
                $albums = new Model_DbTable_Albums();
                $form->populate($albums->getAlbum($id));
            }
        }   
    }

    public function deleteAction()
    {
        $this->view->title = "Delete album";
        $this->view->headTitle($this->view->title, 'PREPEND');
        
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Yes') { 
                $id = $this->getRequest()->getPost('id');
                $albums = new Model_DbTable_Albums();
                $albums->deleteAlbum($id);
            }
            $this->_redirect('/');
        } else {
            $id = $this->_getParam('id', 0);
            $albums = new Model_DbTable_Albums();
            $this->view->album = $albums->getAlbum($id);
        } 
    }
}







