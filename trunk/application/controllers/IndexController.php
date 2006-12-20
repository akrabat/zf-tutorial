<?php

class IndexController extends Zend_Controller_Action 
{
    function init()
    {
        Zend::loadClass('Album');
    }

    function indexAction()
    {
        $view = Zend::registry('view');
        $view->title = "My Albums";
        
        $album = new Album();
        $view->albums = $album->fetchAll();
        
        $view->actionTemplate = 'indexIndex.tpl.php';
        $this->_response->setBody($view->render('site.tpl.php'));
    }
    
    function addAction()
    {
        $view = Zend::registry('view');
        $view->title = "Add New Album";
        
        if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
            $post = Zend::registry('post');
	    	$artist = trim($post->noTags('artist'));
	        $title = trim($post->noTags('title'));
	        
	        if ($artist != '' && $title != '') {
				$data = array(
				    'artist' => $artist,
				    'title'  => $title,
				);
				$album = new Album();
				$album->insert($data);
			
	    	    $this->_redirect('/');
	    	    return;
	        }
        } 
        
        // set up an "empty" album
        $view->album = new stdClass();
        $view->album->artist = '';
        $view->album->title = '';

        // additional view fields required by form
        $view->action = 'add';
        $view->buttonText = 'Add';
        
        $view->actionTemplate = 'indexAdd.tpl.php';
        $this->_response->setBody($view->render('site.tpl.php'));
    }
    
    function editAction()
    {
        $view = Zend::registry('view');
        $view->title = "Edit Album";
        $album = new Album();
        
        if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
            $post = Zend::registry('post');
		    $id = $post->testInt('id');
	    	$artist = trim($post->noTags('artist'));
	        $title = trim($post->noTags('title'));
	        
	        if ($id !== false) {
	            if ($artist != '' && $title != '') {
					$data = array(
					    'artist' => $artist,
					    'title'  => $title,
					);
					$where = 'id = ' . $id;
					$album->update($data, $where);
				
		    	    $this->_redirect('/');
		    	    return;
	            } else {
	                $view->album = $album->find($id);
		        }
	        }
        } else {
            // album id should be $params['id']
            $id = (int)$this->_request->getParam('id', 0);
		    if ($id > 0) {
		        $view->album = $album->find($id);
		    }
        }

        // additional view fields required by form
        $view->action = 'edit';
        $view->buttonText = 'Update';
                
        $view->actionTemplate = 'indexEdit.tpl.php';
        $this->_response->setBody($view->render('site.tpl.php'));
	}
    
    function deleteAction()
    {
        $view = Zend::registry('view');
        $view->title = "Delete Album";
        
        $album = new Album();
        if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
            $post = Zend::registry('post');
		    $id = $post->getInt('id');
	        if (strtolower($post->testAlpha('del')) == 'yes' && $id > 0) {
	            $where = 'id = ' . $id;
				$rows_affected = $album->delete($where);
	        }
        } else {
            // album id should be $params['id]
            $params = $this->_request->getParams();
            if (isset($params['id'])) {
                $id = (int)$params['id'];
			    if ($id > 0) {
			        $view->album = $album->find($id);
			        $view->actionTemplate = 'indexDelete.tpl.php';
			        
			        // only render if we have an id.
	                $this->_response->setBody($view->render('site.tpl.php'));
	                return;
			    }
            }
        }
        // redirect back to the album list unless we have rendered the view
   	    $this->_redirect('/');
    }
}