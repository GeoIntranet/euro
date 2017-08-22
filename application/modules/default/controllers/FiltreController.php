<?php
/**
 * Created by PhpStorm.
 * User: gvalero
 * Date: 22/08/2017
 * Time: 12:35
 */

class FiltreController extends Genius_AbstractController
{
    public function indexAction()
    {
        $session = new Zend_Session_Namespace('input');


        $this->view->headTitle()->append('Eurocomputer | Contact ');
        $this->view->headMeta()->appendName('description',"Contact Form");
        $this->view->headMeta()->appendName('keyword',"Easy Living | Login Form");

        $this->view->printer = $session->printer;
        $this->view->session = $session->input;
        $this->view->subheader = "statics/subheader.phtml";
    }

    public function makefiltreAction()
    {
        $post = $this->getRequest()->getPost();
        $session = new Zend_Session_Namespace('input');

        $session->printer['dpi'] = $post['dpi'];
        $session->printer['gamme'] = $post['gamme'];
        $session->printer['opt'] = $post['opt'];
        $session->printer['use'] = $post['use'];
        $int = array_flip($post['interface']);
        $session->printer['interface'] = $int;

        $baseUrl = new Zend_View_Helper_BaseUrl();
        $this->getResponse()->setRedirect($baseUrl->baseUrl().'/filtre');

    }

    public function makefiltreformAction()
    {
        $session = new Zend_Session_Namespace('input');
        $session->input['search'] = $_GET['f'];

        $baseUrl = new Zend_View_Helper_BaseUrl();
        $this->getResponse()->setRedirect($baseUrl->baseUrl().'/filtre');

    }


    public function deletefiltreAction()
    {
        $session = new Zend_Session_Namespace('input');

        if ($session->input['search'] == 'p' ) unset($session->printer) ;
        elseif($session->input['search'] == 'd' )  unset($session->douchette) ;
        elseif($session->input['search'] == 't' )  unset($session->terminal) ;
        else{
            unset($session->printer) ;
            unset($session->douchette);
            unset($session->terminal);
        }

        $baseUrl = new Zend_View_Helper_BaseUrl();
        $this->getResponse()->setRedirect($baseUrl->baseUrl().'/filtre');

    }

}