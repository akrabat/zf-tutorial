<?php

class IndexController extends Zend_Controller_Action 
{
    function indexAction()
    {
        $this->view->title = "My Albums";
        $albums = new Albums();
        $this->view->albums = $albums->fetchAll();
        
    }
    
    function addAction()
    {
        $this->view->title = "Add New Album";
        
        $form = new AlbumForm();
        $form->submit->setLabel('Add');
        $this->view->form = $form;
        
        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                $albums = new Albums();
                $row = $albums->createRow();
                $row->artist = $form->getValue('artist');
                $row->title = $form->getValue('title');
                $row->save();
                
                $this->_redirect('/');
            } else {
                $form->populate($formData);
            }
        }
    }
    
    function editAction()
    {
        $this->view->title = "Edit Album";
        
        $form = new AlbumForm();
        $form->submit->setLabel('Save');
        $this->view->form = $form;
        
        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                $albums = new Albums();
                $id = (int)$form->getValue('id');
                $row = $albums->fetchRow('id='.$id);
                $row->artist = $form->getValue('artist');
                $row->title = $form->getValue('title');
                $row->save();
                
                $this->_redirect('/');
            } else {
                $form->populate($formData);
            }
        } else {
            // album id is expected in $params['id']
            $id = (int)$this->_request->getParam('id', 0);
            if ($id > 0) {
                $albums = new Albums();
                $album = $albums->fetchRow('id='.$id);
                $form->populate($album->toArray());
            }
        }
    }
    
    function deleteAction()
    {
        $this->view->title = "Delete Album";
        
        if ($this->_request->isPost()) {
            $id = (int)$this->_request->getPost('id');
            $del = $this->_request->getPost('del');
            if ($del == 'Yes' && $id > 0) {
                $albums = new Albums();
                $where = 'id = ' . $id;
                $albums->delete($where);
            }
            $this->_redirect('/');
        } else {
            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
                $albums = new Albums();
                $this->view->album = $albums->fetchRow('id='.$id);
            }
        }
    }
}

