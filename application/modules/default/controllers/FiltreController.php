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

       isset($session->input['search']) ? $session->input['search'] = $session->input['search'] : $session->input['search'] ='p';

        $this->view->headTitle()->append('Eurocomputer | Contact ');
        $this->view->headMeta()->appendName('description',"Contact Form");
        $this->view->headMeta()->appendName('keyword',"Easy Living | Login Form");
        $this->view->result = $session->result;
        $this->view->obj = $this;

        if( $session->printer == null) {
            global $db;
            $result = new Genius_Model_Filtre();
            $result = $result->select();
            $result = $db->query($result)->fetchAll();
            $this->view->result = $result;
        }


        //Image Product
        //$photocover_product = Genius_Model_Product::getProductImageCoverById(16);
        //$path = (!empty($photocover_product)) ? $photocover_product['path_folder'] . '/' . $photocover_product['filename'] . '-small-' . $photocover_product['id_image'] . '.' . $photocover_product['format'] : '';
        //$photocrh_cover = THEMES_DEFAULT_URL . 'images/non_dispo.png';
        //if (file_exists(UPLOAD_PATH . 'images/' . $path) && is_file(UPLOAD_PATH . 'images/' . $path)) {
        //    $photocrh_cover = UPLOAD_URL . 'images/' . $path;
        //}
        //var_dump($path);
        //var_dump($photocover_product);
        //die();

        $this->view->printer = $session->printer;
        $this->view->session = $session->input;
        $this->view->subheader = "statics/subheader.phtml";
    }

    public function makefiltreAction()
    {
        // Les input choix user
        $post = $this->getRequest()->getPost();

        // Instance de la session
        $session = new Zend_Session_Namespace('input');

        // Instance de la classe qui vas gerer a tout filtrer et faire
        // La recherche dans la base de donnée
        $filtering = new Genius_Class_FilteringPrinter($post);

        if($session->input['search'] == 'd') $filtering = new Genius_Class_FilteringDouchette($post);
        if($session->input['search'] == 't') $filtering = new Genius_Class_FilteringTerminal($post);

        $result = $filtering
            ->setSession($session)
            ->handle()
            ->search()
        ;
        $session->result = $result;

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
        unset($session->result);

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