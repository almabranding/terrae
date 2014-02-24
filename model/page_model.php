<?php

class Page_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function contactForm() {
        $user = $this->getUser();
        $action = URL . RUTE;
        $atributes = array(
            'enctype' => 'multipart/form-data',
        );
        $form = new Zebra_Form('contactForm', 'POST', $action, $atributes);
        $form->add('hidden', 'contact','contact');
        $form->add('label', 'label_company', 'company', $this->lang['company'] . ':');
        $obj = $form->add('text', 'company', '', array('autocomplete' => 'off', 'placeholder' => $this->lang['company']));
        $obj->set_rule(array(
            'required' => array('error', $this->lang['company'] . ' ' . $this->lang['is required'] . '!'),
        ));
        $form->add('label', 'label_name', 'name', $this->lang['firstname'] . ':');
        $obj = $form->add('text', 'name', $user['first_name'] . ' ' . $user['last_name'], array('autocomplete' => 'off', 'placeholder' => $this->lang['firstname']));
        $obj->set_rule(array(
            'required' => array('error', $this->lang['firstname'] . ' ' . $this->lang['is required'] . '!'),
        ));
        $form->add('label', 'label_email', 'email', $this->lang['email'] . ':');
        $obj = $form->add('text', 'email', $user['email'], array('autocomplete' => 'off', 'placeholder' => $this->lang['Contact e-mail']));
        $obj->set_rule(array(
            'required' => array('error', $this->lang['email'] . ' ' . $this->lang['is required'] . '!'),   
            'email'     => array('error', $this->lang['email_valid']),
        ));
        $form->add('label', 'label_phone', 'phone', 'Phone:');
        $form->add('text', 'phone', $user['phone'], array('autocomplete' => 'off', 'placeholder' => $this->lang['Contact phone']));

        $form->add('label', 'label_city', 'city', $this->lang['city'] . ':');
        $obj = $form->add('text', 'city', $user['city'], array('autocomplete' => 'off', 'placeholder' => $this->lang['city']));
        $obj->set_rule(array(
            'required' => array('error', $this->lang['city'] . ' ' . $this->lang['is required'] . '!'),
        ));
        $form->add('label', 'label_country', 'country', $this->lang['country'] . ':');
        $obj = $form->add('text', 'country', $user['country'], array('autocomplete' => 'off', 'placeholder' => $this->lang['country']));
        $obj->set_rule(array(
            'required' => array('error', $this->lang['country'] . ' ' . $this->lang['is required'] . '!'),
        ));
        $form->add('label', 'label_request', 'request', $this->lang['Please write your requests'] . ':');
        $obj = $form->add('textarea', 'request', '');
        $obj->set_rule(array(
            'required' => array('error', $this->lang['request'] . ' ' . $this->lang['is required'] . '!'),
        ));
        $form->add('label', 'label_terms', 'terms_1', $this->lang['I accept the legal conditions']);
        $obj = $form->add('radios', 'terms', array(
            '1' => '1',
                ), false);
        $obj->set_rule(array(
            'required' => array('error', $this->lang['terms'] . ' ' . $this->lang['is required'] . '!'),
        ));
        $form->add('submit', '_btnsubmit', 'SEND');

        if ($form->validate()) {
          //  show_results();
        }
        return $form;
    }

}
