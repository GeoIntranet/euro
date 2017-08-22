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
        $filtre = new Genius_Model_Filtre();
        $articles = $filtre::getArticles();

        $input = ['test' => 'test'];
        $filtering = new Genius_Class_Filtering($input);

        var_dump($articles);
        var_dump($filtering);


        $this->view->headTitle()->append('Eurocomputer | Contact ');
        $this->view->headMeta()->appendName('description',"Contact Form");
        $this->view->headMeta()->appendName('keyword',"Easy Living | Login Form");

        $this->view->subheader = "statics/subheader.phtml";
    }
}