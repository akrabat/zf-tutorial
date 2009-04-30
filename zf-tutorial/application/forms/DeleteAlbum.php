<?php

class Form_DeleteAlbum extends Zend_Form
{
    public function __construct($options = null)
    {
        parent::__construct($options);
        $this->setName('delete_album');

        $id = new Zend_Form_Element_Hidden('id');

        $yesButton = new Zend_Form_Element_Submit('Yes');
        $yesButton->setLabel('Yes');
        $yesButton->setAttrib('class', 'submitbutton');

        $noButton = new Zend_Form_Element_Submit('no');
        $noButton->setLabel('No');
        $noButton->setAttrib('class', 'submitbutton');

        $this->addElements(array($id, $yesButton, $noButton));
    }
}