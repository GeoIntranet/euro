<?php

class IndexController extends Genius_AbstractController {

    public function indexAction() {
        $this->view->slider = "statics/slider.phtml";
        $this->view->active = 'index';
    }
	
	public function getallmarquesAction(){
		$this->_helper->layout->disableLayout();
	}

}