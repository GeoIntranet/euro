<?php

class FiltreController extends Genius_AbstractController
{

    public function makefiltreAction()
    {
        $session = new Zend_Session_Namespace();

        $session->post = $_POST;
        $session->input = $this->getRequest()->getPost('test');

        var_dump($_POST);
        var_dump($session->hdw);

        foreach ($session->hdw as $index => $item) {
            $dpi = $_POST['dpi'];
            if($item['dpi'] <> $dpi) unset($session->hdw[$index]);
        }
        var_dump($session->hdw);
        die();

        $baseUrl = new Zend_View_Helper_BaseUrl();
        $this->getResponse()->setRedirect($baseUrl->baseUrl() . '/filtre');
    }

    public function deletefiltreAction()
    {
        $session = new Zend_Session_Namespace();
        unset( $session->input );

        $baseUrl = new Zend_View_Helper_BaseUrl();
        $this->getResponse()->setRedirect($baseUrl->baseUrl() . '/filtre');
    }

}