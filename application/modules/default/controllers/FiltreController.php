<?php

class FiltreController extends Genius_AbstractController
{
    public function indexAction()
    {
        $session = new Zend_Session_Namespace('filtre');
        $dispatcher = new Genius_Class_dispatchFilter($session);

        $dispatcher->result();

        $this->view->result = $dispatcher->getResult();
        $this->view->input = $dispatcher->getInput();
        $this->view->search = $session->search;
        $this->view->subheader = "statics/subheader.phtml";

    }

    /**
     * Applique le filtre en fonction de la section choisit et des inputs
     */
    public function makefiltreAction()
    {

        // Instance de la session
        $session = new Zend_Session_Namespace('filtre');

        // Instance de la classe qui vas gerer a tout filtrer et faire
        // La recherche dans la base de donnée
        $filtering = new Genius_Class_FilteringPrinter($_POST);
        if($session->search == 'd') $filtering = new Genius_Class_FilteringDouchette($_POST);
        if($session->search == 't') $filtering = new Genius_Class_FilteringTerminal($_POST);

        //Gestion du filtre ----
        $filtering
            ->setSession($session)
            ->handle()
            ->search()
            ->setResult()
        ;

        $baseUrl = new Zend_View_Helper_BaseUrl();
        $this->getResponse()->setRedirect($baseUrl->baseUrl().'/filtre');
    }

    /**
     * Change de section Imprimante / Douchette / Terminal
     */
    public function makefiltreformAction()
    {
        $session = new Zend_Session_Namespace('filtre');
        $session->search = $_GET['f'];

        $baseUrl = new Zend_View_Helper_BaseUrl();
        $this->getResponse()->setRedirect($baseUrl->baseUrl().'/filtre');

    }

    /**
     * Reset des resultat
     */
    public function deletefiltreAction()
    {
        $session = new Zend_Session_Namespace('filtre');

        unset($session->resultPrinter);
        unset($session->resultDouchette);
        unset($session->resultTerminal);

        if ($session->search == 'p' ) unset($session->inputPrinter) ;
        elseif($session->search == 'd' )  unset($session->inputDouchette) ;
        elseif($session->search == 't' )  unset($session->inputTerminal) ;
        else{
            unset($session->inputPrinter) ;
            unset($session->inputDouchette);
            unset($session->inputTerminal);
        }

        $baseUrl = new Zend_View_Helper_BaseUrl();
        $this->getResponse()->setRedirect($baseUrl->baseUrl().'/filtre');

    }

}