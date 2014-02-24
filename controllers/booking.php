<?php

class Booking extends Controller {

    function __construct() {
        parent::__construct();
        if (Session::get('userid') == '' || Session::get('userid') == 0) {
            $user_model = $this->loadSingleModel('user');
            $user = $user_model->create();
            Session::set('userid', $user);
        }

        $this->view->js = array('page/js/jquery.creditCardValidator.js', 'page/js/custom.js');
        $this->view->css = array('page/css/custom.css');
        $this->view->setBreadcrumb('Booking');
    }

    function confirmation($msg=null) {
        $_POST['checkin'] = Model::getTimeReverse($_POST['checkin']);
        $_POST['checkout'] = Model::getTimeReverse($_POST['checkout']);
        $this->view->bookingForm = $this->model->bookingForm();
        $this->model->getBookingInfo();
        $checkin = new Booking_bridge();
        foreach ($this->model->params as $id => $room) {
            if ($room['numRooms'] != $checkin->CheckAvailabilityForPeriod($room['room_id'], $room['checkin_date'], $room['checkout_date'], $room['numRooms']))
                header('location: /booking/noresults');
            if (isset($_POST['gift'])) {
            $this->model->params[$id]['price']=0;
        }
        }
        foreach ($this->model->params as $id => $room) {
            $this->model->AddToReservation($room['room_id'], $room);
        }
        $this->model->DoReservation('online');
        if (isset($_POST['gift'])) {
            $Gift = $this->loadSingleModel('gift');
            $giftInfo = $Gift->getGiftInfo($_POST['gift']);
            $rooms[0]['hotel_image'] = $giftInfo['gallery'][1];
        }
        $this->view->rooms = $this->model->params;
        $this->view->setBreadcrumb('Confirmation', true);
        $this->view->render('page/booking');
    }

    function giftconfirmation() {
        $this->view->bookingForm = $this->model->bookingForm();
        $giftInfo = $this->model->getGiftTypes($_POST['giftType']);
        $giftInfo['rec_first_name'] = $_POST['first_name'];
        $giftInfo['rec_last_name'] = $_POST['last_name'];
        $giftInfo['rec_email'] = $_POST['email'];
        $giftInfo['rec_message'] = $_POST['message'];
        $giftInfo['giftType'] = $_POST['giftType'];
        $this->view->giftInfo =$this->model->giftInfo = $giftInfo;
        $this->model->giftPrepareReservation();
        $this->view->setBreadcrumb('Confirmation', true);
        $this->view->render('page/booking');
    }

    function noresults($type=null) {
        if($type==null){
        $this->view->message['title'] = $this->view->lang['No results found'];
        $this->view->message['subtitle'] = '';
        $this->view->message['content'] = $this->view->lang['no available criteria'].'<br><a class="back uppercase" onclick="window.history.back();">'.$this->view->lang['back'].'</a>';
        }
        if($type=='invalidCode'){
        $this->view->message['title'] = $this->view->lang['Invalid Code'];
        $this->view->message['subtitle'] = '';
        $this->view->message['content'] = $this->view->lang['have to use a valid code'].'<br><a class="back uppercase" onclick="window.history.back();">'.$this->view->lang['back'].'</a>';
        }
        $this->view->render('page/message');
    }

    function reservation() {
        if (!isset($_POST['giftType'])) {
            $this->model->bookingReservation();
            $this->model->getBookingInfo();
        }
        if (isset($_POST['giftType'])) {
            $id=$this->model->giftReservation();
        }
        $this->view->user = $this->model->getUser(Session::get('userid'));
        $this->view->rooms = $this->model->params;
        $this->view->setBreadcrumb('Complete', true);
        $this->view->render('page/booking_detail');
    }

    function payment() {
        $paypal = new Paypal();
        $paypal->setPaypal();
    }

}
