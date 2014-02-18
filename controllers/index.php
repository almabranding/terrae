<?php

class Index extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('index/js/custom.js');
        $this->view->css = array('index/css/style.css');
    }
    
   function index() {
       $this->view->js[] = 'page/js/splash.js';
       $this->view->sections=$this->model->getSections();
       $this->view->description=$this->model->getDescrption();
       $this->view->sectionsImg=$this->model->getSectionsImg();
       $this->view->render('head',true);
       $this->view->render('page/splash',true);
       $this->view->render('footerHome',true);
    }
    
}