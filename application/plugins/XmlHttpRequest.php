<?php

class Plugin_XmlHttpRequest extends Zend_Controller_Plugin_Abstract
{
    // Ajax : désactive le layout quand une requete ajax est envoyée
    public function postDispatch(Zend_Controller_Request_Abstract $request)
    {
        if ( $request->isXmlHttpRequest() ) {
            Zend_Layout::getMvcInstance()->disableLayout();
        }
    }

}
