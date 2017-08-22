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
        $this->view->headTitle()->append('Eurocomputer | Contact ');
        $this->view->headMeta()->appendName('description',"Contact Form");
        $this->view->headMeta()->appendName('keyword',"Easy Living | Login Form");
        $this->view->subheader = "statics/subheader.phtml";
    }
}