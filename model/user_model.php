<?php

class User_Model extends Model {

    public $_idmodel;
    public $_model;

    public function __construct() {
        parent::__construct();
    }

    public function signupForm() {
        $user = $this->getUser();
        $action = (!$user) ? URL . LANG . '/user/create' : URL . '/user/edit';
        $atributes = array(
            'enctype' => 'multipart/form-data',
        );
        $form = new Zebra_Form('signup', 'POST', $action, $atributes);
        $form->add('hidden', 'accounttype', 'user');
        $form->add('label', 'label_firstname', 'firstname', $this->lang['fullname'] . ':');
        $obj = $form->add('text', 'firstname', $user['first_name'], array('autocomplete' => 'off', 'placeholder' => $this->lang['Fullname of the booker']));
        $obj->set_rule(array(
            'required' => array('error', $this->lang['fullname'] . ' ' . $this->lang['is required'] . '!'),
        ));

        $form->add('label', 'label_lastname', 'lastname', $this->lang['surname'] . ':');
        $obj = $form->add('text', 'lastname', $user['last_name'], array('autocomplete' => 'off', 'placeholder' => $this->lang['Fullname of the booker']));
        $obj->set_rule(array(
            'required' => array('error', $this->lang['surname'] . ' ' . $this->lang['is required'] . '!'),
        ));
        $form->add('label', 'label_email', 'email', $this->lang['email'] . ':');
        $obj = $form->add('text', 'email', $user['email'], array('autocomplete' => 'off', 'placeholder' => $this->lang['Contact e-mail']));
        $obj->set_rule(array(
            'required' => array('error', $this->lang['email'] . ' ' . $this->lang['is required'] . '!'),    
            'email'     =>  array('error', $this->lang['email_valid']),

        ));
        
        $form->add('label', 'label_phone', 'phone', 'Phone:');
        $form->add('text', 'phone', $user['phone'], array('autocomplete' => 'off', 'placeholder' => $this->lang['Contact phone']));

        $form->add('label', 'label_year', 'year', 'Birthday:');
        $obj = $form->add('select', 'year', $user['year'], array('autocomplete' => 'off'));
        for ($i = 1960; $i < 2014; $i++) {
            $obt[$i] = $i;
        }
        $obj->add_options($obt);
        $obj->set_rule(array(
            'required' => array('error', $this->lang['year'] . ' ' . $this->lang['is required'] . '!'),
        ));
        unset($obt);

        $form->add('label', 'label_city', 'city', 'City:');
        $form->add('text', 'city', $user['city'], array('autocomplete' => 'off', 'placeholder' => 'City of the booker'));

        $form->add('label', 'label_country', 'country', 'Country:');
        $form->add('text', 'country', $user['country'], array('autocomplete' => 'off', 'placeholder' => 'Country of the booker'));

        // "password"
        if (!$user)
            $rule['required'] = array('error', $this->lang['password'].' is required!');
        $rule['length'] = array(6, 10, 'error', $this->lang['password_length']);
        $form->add('label', 'label_password', 'password', $this->lang['chose password'].':');
        $obj = $form->add('password', 'password', '');
        $obj->set_rule($rule);
        
        $form->add('note', 'note_password', 'password', 'Password must be have between 6 and 10 characters.');

        // "confirm password"
        $form->add('label', 'label_confirm_password', 'confirm_password', $this->lang['confirm password'].':');
        $obj = $form->add('password', 'confirm_password', '', array('autocomplete' => 'off', 'compare' => array('password', 'error', 'Password not confirmed correctly!')));

        $form->add('submit', '_btnsubmit', (!$user) ? $this->lang['register'] : $this->lang['save']);

        if ($form->validate()) {
            show_results();
        }
        return $form;
    }

    public function resetForm() {
        $user = $this->getUser();
        $action = URL . 'user/resetpassword/' . $_GET['id'];
        $atributes = array(
            'enctype' => 'multipart/form-data',
        );
        $form = new Zebra_Form('signup', 'POST', $action, $atributes);
        $form->add('hidden', 'id', $_GET['id']);
        $form->add('hidden', 'hash', $_GET['hash']);
        $rule['required'] = array('error', 'Password is required!');
        $rule['length'] = array(6, 10, 'error', 'The password must have between 6 and 10 characters');
        $form->add('label', 'label_password', 'password', 'Choose a password:');
        $obj = $form->add('password', 'password', '', $rule);
        $form->add('note', 'note_password', 'password', 'Password must be have between 6 and 10 characters.');

        // "confirm password"
        $form->add('label', 'label_confirm_password', 'confirm_password', 'Confirm password:');
        $obj = $form->add('password', 'confirm_password', '', array('autocomplete' => 'off', 'compare' => array('password', 'error', 'Password not confirmed correctly!')));

        $form->add('submit', '_btnsubmit', 'Reset Password');

        if ($form->validate()) {
            show_results();
        }
        return $form;
    }

    public function rememberForm() {
        $user = $this->getUser();
        $action = URL . 'user/remember/sent';
        $atributes = array(
            'enctype' => 'multipart/form-data',
        );
        $form = new Zebra_Form('signup', 'POST', $action, $atributes);

        $form->add('label', 'label_email', 'email', 'Email:');
        $form->add('text', 'email', $user['email'], array('autocomplete' => 'off', 'placeholder' => 'Contact e-mail', 'required' => array('error', 'Password is required!'), 'email' => array('error', 'Email address seems to be invalid!')));

        $form->add('submit', '_btnsubmit', 'Remember Password');

        if ($form->validate()) {
            show_results();
        }
        return $form;
    }

    public function loginForm() {
        $action = URL . 'user/login';
        $atributes = array(
            'enctype' => 'multipart/form-data',
        );
        $form = new Zebra_Form('login-form', 'POST', $action, $atributes);
        $form->add('hidden', 'accounttype', 'user');

        $form->add('label', 'label_email', 'email', 'Email:');
        $form->add('text', 'email', '', array('autocomplete' => 'off', 'placeholder' => 'E-mail', 'required' => array('error', 'Password is required!'), 'email' => array('error', 'Email address seems to be invalid!')));

        $form->add('label', 'label_password', 'password', 'Password:');
        $obj = $form->add('password', 'password', '');
        $obj->set_rule(array(
            'required' => array('error', 'Password is required!'),
            'length' => array(6, 10, 'error', 'The password must have between 6 and 10 characters'),
        ));

        $form->add('submit', '_btnsubmit', 'SIGN IN');
        $form->validate();
        return $form;
    }

    public function create($mail = true) {
        $data = array(
            'first_name' => $_POST['firstname'],
            'last_name' => $_POST['lastname'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'year' => $_POST['year'],
            'city' => $_POST['city'],
            'country' => $_POST['country'],
            'account_type' => $_POST['accounttype'],
            'date_created' => $this->getTimeSQL(),
            'date_updated' => $this->getTimeSQL(),
            'is_active' => 0,
        );
        if (isset($_POST['email']))
            $exist = $this->db->selectOne('SELECT * FROM book_customers WHERE email=:email', array('email' => $_POST['email']));
        if ($exist)
            return 0;
        if (isset($_POST['password']) && $_POST['password'] != '')
            $data['user_password'] = md5($_POST['password']);
        else
            $data['user_password'] = rand();
        $userId = $this->db->insert(DB_PREFIX . 'customers', $data);

        if ($mail)
            $this->sendConfirmationMail($userId);
        return $userId;
    }

    public function sendRememberMail() {
        $user = $this->db->selectOne('SELECT * FROM book_customers WHERE email=:mail', array('mail' => $_POST['email']));
        $mail = new MailHelper();
        $mail->getRememberMail($user);
    }

    public function controlMail() {
        if (isset($_POST['id']) && isset($_POST['hash'])) {
            $id = $_POST['id'];
            $hash = $_POST['hash'];
        } else if (isset($_GET['id']) && isset($_GET['hash'])) {
            $id = $_GET['id'];
            $hash = $_GET['hash'];
        }
        if (Hash::create('sha256', $id, HASH_PASSWORD_KEY) == $hash)
            return true;
        return false;
    }

    public function sendConfirmationMail($id) {
        $user = $this->db->selectOne('SELECT * FROM book_customers WHERE id=' . $id);
        $mail = new MailHelper();
        $mail->getConfirmationMail($user);
    }

    public function activate($id, $hash) {
        $user = $this->db->selectOne('SELECT * FROM book_customers WHERE id=' . $id);
        if ($hash == Hash::create('sha256', $user['id'], HASH_PASSWORD_KEY)) {
            $data = array('is_active' => 1,);
            $this->db->update('book_customers', $data, "`id` = '{$id}'");
            return true;
        }
        return false;
    }

    public function reset() {
        if (isset($_POST['password']) && $_POST['password'] != '')
            $data['user_password'] = md5($_POST['password']);
        return $this->db->update('book_customers', $data, "`id` = '{$_POST['id']}'");
    }

    public function edit() {
        $user = $this->getUser();
        $data = array(
            'first_name' => $_POST['firstname'],
            'last_name' => $_POST['lastname'],
            'email' => $_POST['email'],
            'year' => $_POST['year'],
            'phone' => $_POST['phone'],
            'city' => $_POST['city'],
            'country' => $_POST['country'],
            'account_type' => $_POST['accounttype'],
            'date_updated' => $this->getTimeSQL(),
        );
        if (isset($_POST['password']) && $_POST['password'] != '')
            $data['user_password'] = md5($_POST['password']);
        Session::set('username', $data['first_name'] . ' ' . $data['last_name']);
        return $this->db->update('book_customers', $data, "`id` = '{$user['id']}'");
    }

    public function delete($id) {
        $this->db->delete('book_customers', "`id` = {$id}");
    }

    public function login() {
        $sth = $this->db->prepare("SELECT * FROM book_customers WHERE 
                email = :email AND user_password = :password");
        $sth->execute(array(
            ':email' => $_POST['email'],
            ':password' => md5($_POST['password'])
        ));
        $data = $sth->fetch();
        $count = $sth->rowCount();
        if ($count > 0) {
            Session::set('account_type', 'customer');
            Session::set('loggedIn', true);
            Session::set('username', $data['first_name'] . ' ' . $data['last_name']);
            Session::set('userid', $data['id']);
            header('location: ' . URL . 'experience');
        } else {
            header('location: ' . URL . 'experience');
        }
    }

    public function forceLogin($id) {
        $sth = $this->db->prepare("SELECT * FROM book_customers WHERE id = :id");
        $sth->execute(array(
            ':id' => $id
        ));
        $data = $sth->fetch();
        $count = $sth->rowCount();
        if ($count > 0) {
            Session::set('account_type', 'customer');
            Session::set('loggedIn', true);
            Session::set('username', $data['first_name'] . ' ' . $data['last_name']);
            Session::set('userid', $data['id']);
            header('location: ' . URL . 'experience');
        } else {
            header('location: ' . URL . 'experience');
        }
    }

    public function createRandom() {
        
    }

    public function logout() {
        Session::set('account_type', '');
        Session::set('loggedIn', false);
        Session::set('userid', '');
        Session::destroy();
        header('location: ' . URL . 'experience');
    }

    public function getUser() {
        if (Session::get('loggedIn')) {
            return $this->db->selectOne('SELECT * FROM book_customers WHERE id=:id', array('id' => Session::get('userid')));
        }
        return false;
    }

    public function getBookings($lang=LANG) {
        if (Session::get('loggedIn')) {
            return $this->db->select('SELECT * FROM ' . DB_PREFIX . 'bookings b
                JOIN  ' . DB_PREFIX . 'bookings_rooms br ON br.booking_number=b.booking_number
                JOIN  ' . DB_PREFIX . 'rooms r ON br.room_id=r.id
                JOIN  ' . DB_PREFIX . 'hotels_description hd ON br.hotel_id=hd.hotel_id 
                WHERE  hd.language_id=:lang AND b.status>0 AND b.customer_id=:id', array('lang'=>$lang,'id' => Session::get('userid')));
        }
        return false;
    }

    public function getBooking($id,$lang=LANG) {
        return $this->db->select(
                        'SELECT * FROM ' . DB_PREFIX . 'bookings b 
                JOIN  ' . DB_PREFIX . 'bookings_rooms br ON br.booking_number=b.booking_number
                JOIN  ' . DB_PREFIX . 'rooms r ON br.room_id=r.id
                JOIN  ' . DB_PREFIX . 'hotels_description hd ON br.hotel_id=hd.hotel_id
                WHERE hd.language_id=:lang AND b.booking_number=:id'
                        , array('lang'=>$lang,'id' => $id));
    }

}
