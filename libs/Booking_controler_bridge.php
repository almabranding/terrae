<?php

class Booking_controler_bridge extends Controller {

    public $type;
    public $typeName;

    public function __construct($type) {
        parent::__construct();
        $this->type=$type;
        $this->view->searchVar=array('type'=>$this->type,'view'=>$this->view);
    }
    function home($name = null) {
        if($name==null){ 
            header('location: ' . URL.Model::getType($this->type).'/home/piacenza');
        }
        Session::set('destination',$name);
        $this->view->destination=$name;
        $this->view->js[] = 'page/js/home.js';
        $this->view->js[] = 'page/js/jquery.royalslider.min.js';
        $this->view->suggestions = $this->model->getSuggestions();
        $this->view->banners = $this->model->getBanners($name, $this->type);
        $this->view->search = $this->model->searchForm();
        $this->view->setBreadcrumb('Home', true);
        $this->view->render('page/home');
    }

    function results() {
        $this->view->js[] = '../public/js/zebra_datepicker.js';
        $this->view->js[] = 'page/js/results.js';
        $this->view->search = $this->model->searchForm();
        $this->model->check_availability();
        $this->view->availability = $this->model->arrAvailableRooms;
        if(!$this->view->availability) 
            header('location: /' . Model::getType($this->type).'/noresults');
        $this->view->bookingInfo = $this->model->getBookingInfo();
        $this->view->render('page/results');
    }
    function noresults() {
            $this->view->message['title'] = 'No results found';
            $this->view->message['subtitle'] = '';
            $this->view->message['content'] = 'No hemos encontrado ningun resultado para esta busqueda';
            $this->view->render('page/message');
    }
    function detail($id=null,$name = null,$type=null,$room=null) {
        $this->view->setBreadcrumb(urldecode($name), true);
        $this->view->hotel=$this->model->getHotelInfo($id);
        $this->view->rooms=($room==null)?$this->model->getRoomsHotel($id):$this->model->getRoomInfo($id);
        $this->view->type=$type;
        $this->view->room=$room;
        $this->view->js[] = 'page/js/detail.js';
        $this->view->js[] = '../public/js/zebra_datepicker.js';
        $this->view->js[] = 'page/js/results.js';
        $this->view->search = $this->model->searchForm();
        $this->view->render('page/detail');
    }

}
