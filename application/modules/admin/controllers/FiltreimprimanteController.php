<?php
/**
 * Created by PhpStorm.
 * User: gvalero
 * Date: 28/08/2017
 * Time: 16:26
 */

class Admin_FiltreimprimanteController extends Genius_AbstractController
{
    public function init()
    {

    }

    public function indexAction()
    {
        $baseUrl = new Zend_View_Helper_BaseUrl();
        $this->getResponse()->setRedirect($baseUrl->baseUrl().'/admin/filtreimprimante/all');
    }

    public function imprimanteAction()
    {
        $do = $this->_getParam('do');
        $id = $this->_getParam('id');

        if($do == 'post'){
            var_dump($_POST);
        }
    }

    public function allAction()
    {

        $printers = Genius_Model_Filtre::all();

        $paginator = Zend_Paginator::factory($printers)->setItemCountPerPage(18);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        //var_dump($paginator);


        $current = $paginator->getCurrentPageNumber();
        $total = ceil($paginator->getTotalItemCount()/20);
        $next = $current + 1;
        $prev = $current - 1;


        $this->view->current = $current;
        $this->view->total = $total;
        $this->view->next = $next;
        $this->view->previous = $prev;

        $this->view->printers = $printers;
        $this->view->paginator = $paginator;
    }

    public function postAction()
    {

    }

    public function editAction()
    {
        global $db;
        $id = $this->_getParam('id');

        $request = Genius_Model_Filtre::find($id);

        $printer = $db->query($request)->fetch();

        $this->view->printer = $printer;

    }

    public function updateAction()
    {
        global $db;

        $champ = $this->_getParam('n');
        $id = $this->_getParam('id');
        $val = $this->_getParam('val');

        //On inverse la valeur enregistre en bdd actuel soit 1 ou 0
        $value = $val == TRUE ? 0 : 1;

        //on recherche la ligne a update avec une condition where
        $where['ec_filtres.id = ?'] = $id;

        //on passe en tableau le / les parametre a update
        $data[ $champ ] = $value;

        $result = $db->update('ec_filtres',$data,$where);

        $baseUrl = new Zend_View_Helper_BaseUrl();
        $this->getResponse()->setRedirect($baseUrl->baseUrl().'/admin/filtreimprimante/all');
    }

}