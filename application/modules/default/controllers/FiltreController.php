<?php

class FiltreController extends Genius_AbstractController
{

    public function showfiltreAction()
    {
//        $baseUrl = new Zend_View_Helper_BaseUrl();
//        $this->getResponse()->setRedirect($baseUrl->baseUrl().'/reparation');

        var_dump('response');
        var_dump($_SESSION);


    }

    public function makefiltreAction()
    {
        $_SESSION['input'] = 'TEST';
        var_dump($_SESSION);
        var_dump($this->getRequest()->getPost('test'));
        var_dump($this->getRequest());
        var_dump($_POST);
        die();
        //$baseUrl = new Zend_View_Helper_BaseUrl();
        //$this->getResponse()->setRedirect($baseUrl->baseUrl() . '/filtre');
    }

    public function deletefiltreAction()
    {
        unset( $_SESSION['input'] );

        $baseUrl = new Zend_View_Helper_BaseUrl();
        $this->getResponse()->setRedirect($baseUrl->baseUrl() . '/filtre');
    }

}