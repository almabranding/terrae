<?php

class Page extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('page/js/custom.js');
        $this->view->css = array('page/css/custom.css');
    }
    
    
    function view($page) {
        if(isset($_POST['contact'])){
            $MailHelper=new MailHelper();
            $MailHelper->sendContact();
        }
       $this->view->setBreadcrumb(ucfirst($page),true);
       $this->view->contactForm=$this->model->contactForm();
       $this->view->article=$this->model->getArticle($page);
       $this->view->render('page/article');
    }
    
}