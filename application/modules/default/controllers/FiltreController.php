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
     * route : filtre/apply
     * Applique le filtre en fonction de la section choisit et des inputs
     */
    public function makefiltreAction()
    {

        // Instance de la session
        $session = new Zend_Session_Namespace('filtre');
        $session->setExpirationSeconds( 600);

        // Instance de la classe qui vas gerer a tout filtrer et faire
        // La recherche dans la base de donnée
        $filtering = new Genius_Class_FilteringPrinter($_POST);
        if($session->search == 'search_douchette') $filtering = new Genius_Class_FilteringDouchette($_POST);
        if($session->search == 'search_Terminal') $filtering = new Genius_Class_FilteringTerminal($_POST);



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
     * route : /filtre/form?f=xxxx
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

        unset($session->resultThermique);
        unset($session->resultDouchette);
        unset($session->resultTerminal);

        if ($session->search == 'search_thermique' ) unset($session->inputThermique) ;
        elseif($session->search == 'search_douchette' )  unset($session->inputDouchette) ;
        elseif($session->search == 'search_terminal' )  unset($session->inputTerminal) ;
        else{
            unset($session->inputThermique) ;
            unset($session->inputDouchette);
            unset($session->inputTerminal);
        }

        $baseUrl = new Zend_View_Helper_BaseUrl();
        $this->getResponse()->setRedirect($baseUrl->baseUrl().'/filtre');

    }

}