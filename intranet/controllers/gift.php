<?php

class Gift extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('home/js/custom.js');
        if(!Session::get('loggedIn')) header('location: '.URL);
    }
    function index() { 
        header('location: '.URL.'gift/lista');  
    }
    public function types() 
    {
        $this->view->section='category';
        $this->view->list=$this->model->toTable($this->model->getType(),'Type');
        $this->view->render('gift/list');  
    }
    public function viewType($id=null) 
    {
        $this->view->type=true;
        $this->view->form=$this->model->typeForm($id);
        $this->view->render('gift/edit'); 
    }
    public function createType() 
    {
        $id=$this->model->createType();
        header('location: '.URL.'gift/types');  
    } 
    public function editType($id) 
    {
        $this->model->editType($id);
        header('location: '.URL.'gift/types'); 
    }
    public function deleteType($id) 
    {
        $this->model->deleteType($id);
        header('location: '.URL.'gift/types');  
    }
    
    public function lista() 
    {
        $this->view->section='gift';
        $this->view->list=$this->model->toTable($this->model->getGift());
        $this->view->render('gift/list');  
    }
    public function view($id=null) 
    {
        $this->view->id=$id;
        $this->view->form=$this->model->giftForm($id);
        $this->view->render('gift/edit'); 
    }
    public function gallery($id=null) 
    {
        $this->view->group=$id;
        $this->view->Gallery=$this->model->getGallery($id);
        $this->view->render('gift/gallery'); 
    }
    public function create() 
    {
        $id=$this->model->create();
        header('location: '.URL.'gift/lista');  
    } 
    public function edit($id) 
    {
        $this->model->edit($id);
        header('location: '.URL.'gift/lista'); 
    }
    public function delete($id) 
    {
        $this->model->delete($id);
        header('location: '.URL.'gift/lista');  
    }
    public function sort() 
    {
        $this->model->sort();
    }
    
    public function addImage($group) 
    {
        $img=new upload;
        $this->model->addImage($group,$img->getImg());
    } 
    public function delImage($id,$group) 
    {
        $id=$this->model->delImage($id);
        header('location: '.URL.'gift/gallery/'.$group);  
    }
    
    
    public function bookingList() 
    {
        $this->view->section='booking';
        $this->view->list=$this->model->toTableBooking($this->model->getBookings());
        $this->view->render('gift/list');  
    }
    public function bookingView($id=null) 
    {
        $this->view->id=$id;
        $this->view->form=$this->model->giftBookingForm($id);
        $data=$this->model->getBookings($id);
        $this->view->data=array(
            'Code'=>$data['code'],
            'Status'=>$this->model->getBookingStatus($data['status']),
            'Additional info'=>$data['additional_info'],
            'Status Changed'=>$data['status_changed'],
            'CREDIT CARD INFO'=>'',
            'CC Type'=>$data['cc_type'],
            'CC Name'=>$data['cc_holder_name'],
            'CC Number'=>$data['cc_number'],
            'CC Expires date'=>$data['cc_expires_month'].'-'.$data['cc_expires_year'],
            'CC CVV'=>$data['cc_cvv_code'],
            'BOOKER INFO'=>$data[''],
            'Booker ID'=>$data['customer_id'],
            'Booker Name'=>$data['cname'].' '.$data['clname'],
            'Booker mail'=>$data['cmail'],
            'Booker ID'=>$data['customer_id'],
            'RECEPTOR INFO'=>$data[''],
            'Receptor name'=>$data['rec_first_name'].' '.$data['rec_last_name'],
            'Receptor mail'=>$data['rec_email'],
            'Receptor message'=>$data['rec_message'],
        );
        $this->view->render('gift/viewBooking'); 
    }
    public function editBooking($id){
        $this->model->editBooking($id);
        header('location: '.URL.'gift/bookingList'); 
    }
}