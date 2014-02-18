<?php

// # CreatePaymentSample
//
// This sample code demonstrate how you can process
// a direct credit card payment. Please note that direct 
// credit card payment and related features using the 
// REST API is restricted in some countries.
// API used: /v1/payments/payment

require __DIR__ . '/../bootstrap.php';
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\CreditCard;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Transaction;

        
// ### CreditCard
// A resource representing a credit card that can be
// used to fund a payment.

$card = new CreditCard();
$card->setType($paypal['card']['type'])
	->setNumber($paypal['card']['number'])
	->setExpireMonth($paypal['card']['expireMont'])
	->setExpireYear($paypal['card']['expireYear'])
	->setCvv2($paypal['card']['cvv'])
	->setFirstName($paypal['card']['firstName'])
	->setLastName($paypal['card']['lastName']);

// ### FundingInstrument
// A resource representing a Payer's funding instrument.
// For direct credit card payments, set the CreditCard
// field on this object.
$fi = new FundingInstrument();
$fi->setCreditCard($card);

// ### Payer
// A resource representing a Payer that funds a payment
// For direct credit card payments, set payment method
// to 'credit_card' and add an array of funding instruments.
$payer = new Payer();
$payer->setPaymentMethod("credit_card")
	->setFundingInstruments(array($fi));

// ### Itemized information
// (Optional) Lets you specify item wise
// information
//$item1 = new Item();
//$item1->setName('Ground Coffee 40 oz')
//	->setCurrency('USD')
//	->setQuantity(1)
//	->setPrice('7.50');
//$item2 = new Item();
//$item2->setName('Granola bars')
//	->setCurrency('USD')
//	->setQuantity(5)
//	->setPrice('2.00');

$itemList = new ItemList();
$itemList->setItems($paypal['items']);

$paypal['subtotal']=(!isset($paypal['subtotal']))?0:$paypal['subtotal'];
$paypal['shipping']=(!isset($paypal['shipping']))?0:$paypal['shipping'];
$paypal['tax']=(!isset($paypal['tax']))?0:$paypal['tax'];
foreach($paypal['items'] as $item){
    for($i=1;$i<=$item['quantity'];$i++) $paypal['subtotal']+=$item['price'];
}

// ### Additional payment details
// Use this optional field to set additional
// payment information such as tax, shipping
// charges etc.
$details = new Details();
$details->setShipping(number_format($paypal['shipping'],2))
	->setTax(number_format($paypal['tax'],2))
	->setSubtotal(number_format($paypal['subtotal'],2));
$paypal['total']=$paypal['subtotal']+$paypal['tax']+$paypal['shipping'];

// ### Amount
// Lets you specify a payment amount.
// You can also specify additional details
// such as shipping, tax.
$amount = new Amount();
$amount->setCurrency($paypal['currency'])
	->setTotal(number_format($paypal['total'],2))
	->setDetails($details);

// ### Transaction
// A transaction defines the contract of a
// payment - what is the payment for and who
// is fulfilling it. 
$transaction = new Transaction();
$transaction->setAmount($amount)
	->setItemList($itemList)
	->setDescription("Payment description");

// ### Payment
// A Payment Resource; create one using
// the above types and intent set to sale 'sale'
$payment = new Payment();
$payment->setIntent("sale")
	->setPayer($payer)
	->setTransactions(array($transaction));

// ### Create Payment
// Create a payment by calling the payment->create() method
// with a valid ApiContext (See bootstrap.php for more on `ApiContext`)
// The return object contains the state.
try {
	$payment->create($apiContext);
} catch (PayPal\Exception\PPConnectionException $ex) {
	echo "Exception: " . $ex->getMessage() . PHP_EOL;
	var_dump($ex->getData());
	exit(1);
}
?>
<?php //echo $payment->getId();?>
<?php //var_dump($payment->toArray());?>
