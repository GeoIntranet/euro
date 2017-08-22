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

        $filtering = new Genius_Class_FilteringPrinter($post);
        if($session->input['search'] == 'd') $filtering = new Genius_Class_FilteringDouchette($post);
        if($session->input['search'] == 't') $filtering = new Genius_Class_FilteringTerminal($post);

        $filtering
            ->setSession($session)
            ->handle()
        ;

        $model = new Genius_Model_Filtre();
        $art = $model::getArticles();
        var_dump($model::getArticles());
        die();

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