<?php
class Login_Model extends Model {
    public function __construct() {
        parent::__construct();
    }
    public function run()
    {
        $sth = $this->db->prepare("SELECT * FROM users WHERE 
                email = :email AND passcode = :passcode");
        $sth->execute(array(
            ':email' => $_POST['email'],
            ':passcode' => $_POST['passcode']
        ));
        
        $data = $sth->fetch();
        $count =  $sth->rowCount();
        if ($count > 0) {
            Session::init();
            Session::set('role', $data['role']);
            Session::set('loggedIn', true);
            Session::set('userid', $data['userid']);
            header('location: '.URL.'building/view/gallery');
        } else {
            header('location: '.URL.'login');
        }
        
    }
}