<?php

class Model_DbTable_Albums extends Zend_Db_Table
{
    protected $_name = 'albums';
    
    public function getAlbum($id) 
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            throw new Exception("Count not find row $id");
        }
        return $row->toArray();    
    }
    
    public function addAlbum($artist, $title)
    {
        $data = array(
            'artist' => $artist,
            'title' => $title,
        );
        $this->insert($data);
    }
    
    function updateAlbum($id, $artist, $title)
    {
        $data = array(
            'artist' => $artist,
            'title' => $title,
        );
        $this->update($data, 'id = '. (int)$id);
        
    }
    
    function deleteAlbum($id)
    {
        $this->delete('id =' . (int)$id);
    }
}
