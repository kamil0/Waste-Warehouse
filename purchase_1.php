<?php

use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;

require 'res/start.php';

// Check fields

if( !isset($_POST['product_name'], $_POST['price']) ) {
	die('Error 1: Please retry your request.');
}

$product = $_POST['product_name'];
$price = (float) $_POST['price'];
$shipping = 5.95;

$total = $price + $shipping;


$payer = new Payer();
$payer->setPaymentMethod('paypal');

$item = new Item();

$item->setName($product)
	 ->setCurrency('USD')
	 ->setQuantity(1)
	 ->setPrice($price);

$itemlist = new ItemList();
$itemlist->setItems([$item]);

$details = new Details();
$details->setShipping($shipping)
		->setSubtotal($price);

$amount = new Amount();
$amount->setCurrency('USD')
	   ->setTotal($total)
	   ->setDetails($details);

$transaction = new Transaction();

$transaction->setAmount($amount)
			->setItemList($itemlist)
			->setDescription('Waste Warehouse purchase')
			->setInvoiceNumber(uniqid());

$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl(BASE_URL . '/purchase_2.php?success=true')
			 ->setCancelUrl(BASE_URL . '/purchase_2.php?success=false');

$payment = new Payment();
$payment->setIntent('sale')
		->setPayer($payer)
		->setRedirectUrls($redirectUrls)
		->setTransactions([$transaction]);

try {
	$payment->create($paypal);
} catch (Exception $ex) {
	die($ex);
}

$approvalUrl = $payment->getApprovalLink();
header('Location: '.$approvalUrl);