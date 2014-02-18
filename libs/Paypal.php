<?php

class Paypal {

    public $paypal;

    public function __construct() {
    }

    public function setPaypal() {
        $paypal['currency']='USD';
        $paypal['card']=array(
            'type'=>'visa',
            'number'=>'4214730600836056',
            'expireMont'=>'10',
            'expireYear'=>'2017',
            'cvv'=>'454',
            'firstName'=>'Dan',
            'lastName'=>'Triano'
        );
        $paypal['items'][]=array(
            'name'=>'Hotel',
            'currency'=>$paypal['currency'],
            'quantity'=>1,
            'price'=>number_format(0.10,2)
        );
       
        require __DIR__ . '/paypal/sample/payments/Paypal.php';
        var_dump($payment->toArray());
    }

   

}
